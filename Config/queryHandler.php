<?php
require_once 'db.php';

class QueryHandler
{

    public $usersDB;
    public $ticketDB;
    public $inventoryDB;
    public $logsDB;

    public function __construct()
    {
        $db = new database();
        $db->connect();

        $this->usersDB = $db->users_conn;
        $this->ticketDB = $db->ticket_conn;
        $this->inventoryDB = $db->inventory_conn;
        $this->logsDB = $db->logs_conn;
    }

    //login
    public function getUserByEmpId($empId)
    {
        $stmt = $this->usersDB->prepare("
            SELECT u.*, r.*, d.* FROM users u
            JOIN roles r ON u.role_id = r.R_ID
            JOIN departments d ON u.Dept_ID = d.D_ID
            WHERE u.employee_ID = :id
        ");
        $stmt->execute(['id' => $empId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserById($id)
    {
        $stmt = $this->usersDB->prepare("
            SELECT u.*, r.*, d.*,
            CONCAT(u.FN, ' ', u.LN) AS full_name
            FROM users u
            JOIN roles r ON u.role_id = r.R_ID
            JOIN departments d ON u.Dept_ID = d.D_ID
            WHERE u.U_ID = :id
        ");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUsersByRole($roleId)
    {
        $stmt = $this->ticketDB->prepare("
            SELECT U_ID FROM chams_users.users
            WHERE Role_ID = :role
        ");
        $stmt->execute(['role' => $roleId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDepartments()
    {
        $sql = "SELECT D_ID, Dept_Name 
        FROM chams_users.departments 
        ORDER BY Dept_Name ASC";
        $stmt = $this->logsDB->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // update password if ayaw nung sa loginProcess (DO NOT REMOVE PLS)
    public function updatePassword($user_id, $new_hash)
    {
        $stmt = $this->usersDB->prepare("UPDATE users SET pass_hash = :hash WHERE U_ID = :id");
        return $stmt->execute([
            'hash' => $new_hash,
            'id' => $user_id
        ]);
    }

    // update details from settings.php and updateAccount.php
    public function updateUserName($userId, $fn, $ln) {
        $sql = "UPDATE users SET FN = ?, LN = ? WHERE U_ID = ?";
        $stmt = $this->usersDB->prepare($sql);
        return $stmt->execute([$fn, $ln, $userId]);
    }

    public function updateUserPassword($userId, $hashedPassword) {
        $sql = "UPDATE users SET pass_hash = ? WHERE U_ID = ?";
        $stmt = $this->usersDB->prepare($sql);
        return $stmt->execute([$hashedPassword, $userId]);
    }

    // role based for tickets im crien
    public function getTickets($role, $user_id, $filters = [], $page = 1, $limit = 5)
    {
        $params = [];

        // Base SQL
        $sql = "SELECT t.*,
                    t.ticket_num,
                    u.FN, u.LN,
                    s.FN AS staff_FN, s.LN AS staff_LN,
                    c.categ_name
            FROM tickets t
            LEFT JOIN chams_users.users u ON t.Created_By = u.U_ID
            LEFT JOIN chams_users.users s ON t.Assigned_To = s.U_ID
            LEFT JOIN chams_users.departments d ON u.Dept_ID = d.D_ID
            LEFT JOIN ticket_categories c ON t.t_type = c.TC_ID

            WHERE 1=1";

        // SECURITY LAYER
        if ($role == 2) {
            $sql .= " AND (t.Assigned_To = :uid OR (t.Assigned_To IS NULL AND t.Status != 'Resolved'))";
            $params['uid'] = $user_id;
        } elseif ($role != 1) {
            $sql .= " AND t.Created_By = :uid";
            $params['uid'] = $user_id;
        }

        // SEARCH
        if (!empty($filters['search'])) {
            $sql .= " AND (t.ticket_num LIKE :search OR t.Title LIKE :search)";
            $params['search'] = "%" . $filters['search'] . "%";
        }

        // FILTER LAYER
        if (!empty($filters['department']) && $filters['department'] !== 'All') {
            $sql .= " AND d.Dept_Name = :dept_name";
            $params['dept_name'] = $filters['department'];
        }

        if (!empty($filters['name']) && $filters['name'] !== 'All') {
            $sql .= " AND CONCAT(u.FN, ' ', u.LN) = :creator_name";
            $params['creator_name'] = $filters['name'];
        }

        if (!empty($filters['type']) && $filters['type'] !== 'All') {
            $sql .= " AND c.categ_name = :ticket_type";
            $params['ticket_type'] = $filters['type'];
        }

        if (!empty($filters['date']) && $filters['date'] !== 'All') {
            $sql .= " AND DATE(t.created_at) = :selected_date";
            $params['selected_date'] = $filters['date'];
        }

        if (!empty($filters['status']) && $filters['status'] !== 'All') {
            $sql .= " AND t.Status = :status";
            $params['status'] = $filters['status'];
        }

        if (isset($filters['unassigned']) && $filters['unassigned'] == '1') {
            $sql .= " AND (t.Assigned_To IS NULL OR t.Assigned_To = 0 OR t.Assigned_To = '')";
        }

        if (isset($filters['overdue']) && $filters['overdue'] == '1') {
            $sql .= " AND due_date < NOW() ";
        }

        if (!empty($filters['priority']) && $filters['priority'] !== 'All') {
            $sql .= " AND t.Priority = :priority";
            $params['priority'] = $filters['priority'];
        }

        $sortDir = (isset($_GET['sort']) && $_GET['sort'] === 'oldest') ? 'ASC' : 'DESC';
        $sql .= " ORDER BY t.created_at $sortDir";

        $offset = ($page - 1) * $limit;
        $sql .= " LIMIT :limit OFFSET :offset";
        $stmt = $this->ticketDB->prepare($sql);

        foreach ($params as $key => $val) {
            $stmt->bindValue(":$key", $val);
        }

        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTicketById($id)
    {
        $stmt = $this->ticketDB->prepare("
        SELECT t.*,
               tc.categ_name,
               u.FN as creator_FN, u.LN as creator_LN, u.Dept_ID as creator_dept,
               s.FN as staff_FN, s.LN as staff_LN,
               d.dept_name,
               inv.item_name as issued_item_name
        FROM tickets t
        LEFT JOIN ticket_categories tc ON t.t_type = tc.TC_ID
        LEFT JOIN chams_users.users u ON t.Created_By = u.U_ID
        LEFT JOIN chams_users.users s ON t.Assigned_To = s.U_ID
        LEFT JOIN chams_users.departments d ON u.Dept_ID = d.D_ID
        LEFT JOIN chams_inventory.inventory_items inv ON t.issued_item_id = inv.I_ID
        WHERE t.T_ID = :id
    ");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function reopenTicket($id)
    {
        $stmt = $this->ticketDB->prepare("
        UPDATE tickets 
        SET Status = 'Unresolved', 
            resolved_at = NULL, 
            updated_at = NOW() 
        WHERE T_ID = :id
    ");
        return $stmt->execute(['id' => $id]);
    }

    public function updateTicket($ticket_id, $title, $description, $priority, $status, $staff_id, $due_date, $type, $issued_item_id, $issued_qty)
    {
        // Check if the incoming status is 'Resolved'
        $resolvedPart = ($status === 'Resolved') ? ", resolved_at = IFNULL(resolved_at, NOW())" : "";

        $stmt = $this->ticketDB->prepare("
            UPDATE tickets
            SET Title = :title,
                T_description = :desc,
                Priority = :priority,
                Status = :status,
                Assigned_To = :staff,
                t_type = :type,
                due_date = :due,
                updated_at = NOW(),
                issued_item_id = :i_id,
                issued_qty = :i_qty
                $resolvedPart
            WHERE T_ID = :id
        ");

        return $stmt->execute([
            'title' => $title,
            'desc' => $description,
            'priority' => $priority,
            'status' => $status,
            'staff' => !empty($staff_id) ? $staff_id : null,
            'type' => $type,
            'due' => ($due_date !== '') ? $due_date : null,
            'i_id' => !empty($issued_item_id) ? $issued_item_id : null,
            'i_qty' => !empty($issued_qty) ? $issued_qty : 0,
            'id' => $ticket_id
        ]);
    }

    public function resolveTicket($id)
    {
        $stmt = $this->ticketDB->prepare("
            UPDATE tickets SET Status = 'Resolved', resolved_at = NOW()
            WHERE T_ID = :id
        ");
        return $stmt->execute(['id' => $id]);
    }

    public function deleteTicketByNum($tnum)
    {
        $sql = "DELETE FROM tickets WHERE ticket_num = :tnum";
        $stmt = $this->ticketDB->prepare($sql);
        return $stmt->execute(['tnum' => $tnum]);
    }

    // CREATE TICKET
    
    // public function createTicket($desc, $title, $user_id, $dept_id, $categ_id, $attachment = null)
    // INSERT INTO tickets (ticket_num, title, T_description, Created_By, Dept_ID, t_type, attachment, created_at)
    // VALUES (:tnum, :title, :desc, :user, :dept, :categ, :attach, NOW())

    // if you want title i removed it because of professor request
    public function createTicket($desc, $user_id, $dept_id, $categ_id, $attachment = null)
    {
        $ticketNum = $this->generateTicketNum();
        $sql = "
            INSERT INTO tickets (ticket_num, T_description, Created_By, Dept_ID, t_type, attachment, created_at)
            VALUES (:tnum, :desc, :user, :dept, :categ, :attach, NOW())
        ";

        $stmt = $this->ticketDB->prepare($sql);
        $stmt->execute([
            'tnum' => $ticketNum,
            'desc' => $desc,
            'user' => $user_id,
            'dept' => $dept_id,
            'categ' => $categ_id,
            'attach' => $attachment
        ]);
        return $ticketNum;
    }

    public function generateTicketNum()
    {
        $prefix = "TICKET-";
        $randomPart = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));
        return $prefix . $randomPart;
    }

    public function getTicketCategories()
    {
        $stmt = $this->ticketDB->query("SELECT * FROM ticket_categories ORDER BY categ_name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Comments
    public function getTicketComments($ticket_id) {
        $sql = "SELECT tc.*, u.FN, u.LN 
                FROM ticket_comments tc
                JOIN chams_users.users u ON tc.U_ID = u.U_ID
                WHERE tc.T_ID = ?
                ORDER BY tc.created_at DESC";
                
        $stmt = $this->ticketDB->prepare($sql);
        $stmt->execute([$ticket_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addTicketComment($ticket_id, $user_id, $text) {
        $sql = "INSERT INTO ticket_comments (T_ID, U_ID, comment_text, created_at) 
                VALUES (?, ?, ?, NOW())";
                
        $stmt = $this->ticketDB->prepare($sql);
        return $stmt->execute([$ticket_id, $user_id, $text]);
    }

    // ASSIGN TICKET
    public function assignTicket($ticket_id, $staff_id)
    {

        $stmt = $this->ticketDB->prepare("
            UPDATE tickets SET Assigned_To = :staff, Status = 'Ongoing'
            WHERE T_ID = :id
        ");
        return $stmt->execute([
            'staff' => $staff_id,
            'id' => $ticket_id
        ]);
    }

    public function getAllStaff()
    {
        $stmt = $this->usersDB->prepare("
        SELECT U_ID, FN, LN
        FROM users
        WHERE role_id = 2
    ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //dashboard ticket UI for all users
    public function getDashboardStats()
    {

        $data = [];

        // open
        $stmt = $this->ticketDB->query("
        SELECT COUNT(*) as total FROM tickets WHERE Assigned_to is NULL AND Status != 'Resolved'
        ");
        $data['open'] = $stmt->fetch()['total'];

        // overdue
        $stmt = $this->ticketDB->query("
            SELECT COUNT(*) as total FROM tickets
            WHERE Status != 'Resolved' AND due_date < NOW()
        ");
        $data['overdue'] = $stmt->fetch()['total'];

        // unresolved
        $stmt = $this->ticketDB->query("
            SELECT COUNT(*) as total FROM tickets WHERE Status != 'Resolved'
        ");
        $data['status'] = $stmt->fetch()['total'];

        // urgent
        $stmt = $this->ticketDB->query("
            SELECT COUNT(*) as total FROM tickets
            WHERE Status != 'Resolved' AND Priority = 'High'
        ");
        $data['urgent'] = $stmt->fetch()['total'];

        return $data;
    }

    // performance summary (charts for employee performance)
    public function getPerformanceStats($role, $user_id = null)
    {

        $data = ['resolved_month' => 0, 'avg_time' => 0, 'daily_avg' => 0];

        $whereResolved = "WHERE Status = 'Resolved'";
        $whereDaily = "WHERE Status = 'Resolved'";

        // admin sees all
        if ($role === 2 && $user_id !== null) {
            $whereResolved .= " AND Assigned_To = " . intval($user_id);
            $whereDaily .= " AND Assigned_To = " . intval($user_id);
        }

        // monthly resolved
        $stmt = $this->ticketDB->query("
        SELECT COUNT(*) as total FROM tickets
        $whereResolved
        AND MONTH(resolved_at) = MONTH(CURRENT_DATE())
        AND YEAR(resolved_at) = YEAR(CURRENT_DATE())
    ");
        $data['resolved_month'] = $stmt->fetch()['total'] ?? 0;

        // avg time (Time from Created to Resolved)
        $stmt = $this->ticketDB->query("
        SELECT AVG(TIMESTAMPDIFF(HOUR, created_at, resolved_at)) as avg_time
        FROM tickets $whereResolved
    ");
        $data['avg_time'] = round($stmt->fetch()['avg_time'] ?? 0, 1);

        // daily avg tickets
        $stmt = $this->ticketDB->query("
        SELECT COUNT(*) / COUNT(DISTINCT DATE(resolved_at)) as daily_avg
        FROM tickets $whereDaily
    ");
        $data['daily_avg'] = round($stmt->fetch()['daily_avg'] ?? 0, 1);

        return $data;
    }

    public function getStaffPerformanceTable()
    {
        $sql = "
        SELECT 
            u.U_ID,
            CONCAT(u.FN, ' ', u.LN) AS full_name,
            COUNT(t.T_ID) AS ticket_count,
            ROUND(AVG(TIMESTAMPDIFF(HOUR, t.created_at, t.resolved_at)), 1) AS avg_time
        FROM tickets t
        JOIN chams_users.users u ON t.Assigned_To = u.U_ID
        WHERE t.Status = 'Resolved' AND t.resolved_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
        GROUP BY u.U_ID
        ORDER BY ticket_count DESC
    ";

        $stmt = $this->ticketDB->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMonthlyResolved($user_id = null, $role = null)
    {
        $where = "WHERE Status = 'Resolved' AND YEAR(resolved_at) = YEAR(CURRENT_DATE())";

        if ($role == 2) {
            $where .= " AND Assigned_To = " . intval($user_id);
        }

        $sql = "
            SELECT 
                MONTH(resolved_at) as month,
                COUNT(*) as total
            FROM tickets
            $where
            GROUP BY MONTH(resolved_at)
            ORDER BY month ASC
        ";

        $stmt = $this->ticketDB->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // for weekly
    public function getWeeklyResolved($user_id = null, $role = null)
    {
        $where = "WHERE Status = 'Resolved' 
              AND YEAR(resolved_at) = YEAR(CURRENT_DATE()) 
              AND MONTH(resolved_at) = MONTH(CURRENT_DATE())";

        if ($role == 2) {
            $where .= " AND Assigned_To = " . intval($user_id);
        }

        $sql = "
        SELECT 
            WEEK(resolved_at, 1) - WEEK(DATE_FORMAT(resolved_at, '%Y-%m-01'), 1) + 1 AS week,
            COUNT(*) as total
        FROM tickets
        $where
        GROUP BY week
        ORDER BY week ASC
    ";

        $stmt = $this->ticketDB->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStaffRecentActivity($user_id)
    {
        $sql = "
        SELECT 
            t.T_ID,
            t.Title,
            t.resolved_at,
            TIMESTAMPDIFF(HOUR, t.created_at, t.resolved_at) AS response_time
        FROM tickets t
        WHERE t.Assigned_To = :uid
        AND t.Status = 'Resolved'
        ORDER BY t.resolved_at DESC
        LIMIT 5
    ";

        $stmt = $this->ticketDB->prepare($sql);
        $stmt->execute(['uid' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // inventory

    public function getInventoryById($id)
    {
        $sql = "
        SELECT i.*,
             u.FN as creator_FN,
             u.LN as creator_LN,
             c.category_name
        FROM inventory_items i
        LEFT JOIN chams_users.users u ON i.created_by = u.U_ID
        LEFT JOIN inventory_categories c ON i.categ_ID = c.IC_ID
        WHERE i.I_ID = :id";

        $stmt = $this->inventoryDB->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getItemsInGroup($name, $catId, $filter = null)
    {
        $sql = "SELECT i.*, u.FN, u.LN, c.category_name
            FROM inventory_items i
            LEFT JOIN chams_users.users u ON i.created_by = u.U_ID
            LEFT JOIN inventory_categories c ON i.categ_ID = c.IC_ID
            WHERE i.item_name = :name AND i.categ_ID = :catId";

        if ($filter === 'depleted') {
            $sql .= " AND i.Quantity <= 0";
        } else {
            $sql .= " AND i.Quantity > 0";
        }
        $sql .= " ORDER BY i.created_at DESC";

        $stmt = $this->inventoryDB->prepare($sql);
        $stmt->execute(['name' => $name, 'catId' => $catId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllInventory($onlyAvailable = false)
    {
        $sql = "
        SELECT i.*, u.FN, u.LN, u.role_id,
        CASE
            WHEN i.Quantity <= 0 THEN 'DEPLETED'
            ELSE c.category_name
        END AS category_name
        FROM chams_inventory.inventory_items i
        LEFT JOIN chams_users.users u ON i.created_by = u.U_ID
        LEFT JOIN chams_inventory.inventory_categories c ON i.categ_ID = c.IC_ID
        WHERE 1=1
    ";
        if ($onlyAvailable) {
            $sql .= " AND i.Quantity > 0";
        }

        $sql .= " ORDER BY i.created_at DESC";
        $stmt = $this->inventoryDB->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllInventoryWithStatus()
    {
        $stmt = $this->usersDB->prepare("
            SELECT i.*, c.category_name, u.FN as creator_FN, u.LN as creator_LN,
                CASE
                    WHEN i.Quantity <= 0 THEN 'DEPLETED'
                    ELSE c.category_name
                END as display_category
            FROM inventory i
            LEFT JOIN categories c ON i.cat_id = c.C_ID
            LEFT JOIN users u ON i.Created_By = u.U_ID
            ORDER BY i.Quantity ASC -- This puts depleted items at the top
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLowStock()
    {
        $stmt = $this->inventoryDB->query("
        SELECT *, (Quantity - Threshold) as stock_diff
        FROM inventory_items
        WHERE Quantity <= Threshold
        ORDER BY stock_diff ASC
    ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getInventorySummary()
    {
        $stmt = $this->inventoryDB->query("
        SELECT c.category_name, SUM(i.Quantity) as total, category_color
        FROM inventory_items i
        LEFT JOIN inventory_categories c ON i.categ_ID = c.IC_ID
        GROUP BY c.category_name
    ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getInventoryCount($filters = [])
    {
        $sql = "SELECT COUNT(*) FROM inventory_items WHERE 1=1";
        $params = [];

        if (!empty($filters['type']) && $filters['type'] !== 'All') {
            $sql .= " AND categ_ID = :categ";
            $params['categ'] = $filters['type'];
        }

        if (!empty($filters['name']) && $filters['name'] !== 'All') {
            $sql .= " AND item_name LIKE :name";
            $params['name'] = '%' . $filters['name'] . '%';
        }

        if (!empty($filters['date']) && $filters['date'] !== 'All') {
            $sql .= " AND DATE(created_at) = :date";
            $params['date'] = $filters['date'];
        }

        $stmt = $this->inventoryDB->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }

    public function adjustInventoryStock($itemId, $difference, $ticketId, $adminId, $newId = null)
    {
        try {
            $this->inventoryDB->beginTransaction();

            // default invDB change
            $sql1 = "UPDATE inventory_items SET Quantity = Quantity - ? WHERE I_ID = ?";
            $stmt1 = $this->inventoryDB->prepare($sql1);
            $stmt1->execute([$difference, $itemId]);

            // if $newID then swap happened
            if ($newId) {
                $sql2 = "UPDATE inventory_tracker SET I_ID = ?, Quantity = ? WHERE reference_ticket = ?";
                $stmt2 = $this->inventoryDB->prepare($sql2);
                // set the tracker to the final new quantity
                $stmt2->execute([$newId, $difference, $ticketId]);
            } else {
                // quantity adjustment on the same item
                $sql2 = "UPDATE inventory_tracker SET Quantity = Quantity + ? WHERE I_ID = ? AND reference_ticket = ?";
                $stmt2 = $this->inventoryDB->prepare($sql2);
                $stmt2->execute([$difference, $itemId, $ticketId]);
            }

            $this->inventoryDB->commit();
            return true;
        } catch (Exception $e) {
            $this->inventoryDB->rollBack();
            return false;
        }
    }

    public function getInventoryFilterData()
    {
        $sql = "
            SELECT DISTINCT
                d.Dept_Name,
                CONCAT(u.FN, ' ', u.LN) AS full_name
            FROM inventory_items i
            LEFT JOIN chams_users.users u ON i.created_by = u.U_ID
            LEFT JOIN chams_users.departments d ON u.Dept_ID = d.D_ID
            ORDER BY d.Dept_Name ASC, full_name ASC";

        $stmt = $this->inventoryDB->query($sql);

        $departments = ["All"];
        $deptGroups = ["All" => ["All"]];
        $allNames = ["All"];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $dept = $row['Dept_Name'] ?? 'Unknown';
            $name = $row['full_name'];

            if (!in_array($dept, $departments))
                $departments[] = $dept;
            if (!isset($deptGroups[$dept]))
                $deptGroups[$dept] = ["All"];
            if (!in_array($name, $deptGroups[$dept]))
                $deptGroups[$dept][] = $name;
            if (!in_array($name, $allNames))
                $allNames[] = $name;
        }
        $deptGroups["All"] = $allNames;

        return [
            'departments' => $departments,
            'names' => $allNames,
            'groups' => $deptGroups
        ];
    }

    public function updateInventory($id, $categ_ID, $item_name, $item_type, $item_brand, $quantity, $threshold, $item_supplier, $defects, $serial_number, $date_received, $collected_by)
    {

        $sql = "UPDATE inventory_items
            SET categ_ID = ?,
                item_name = ?,
                item_type = ?,
                item_brand = ?,
                Quantity = ?,
                Threshold = ?,
                item_supplier = ?,
                Defects = ?,
                Serial_number = ?,
                date_received = ?,
                collected_by = ?,
                updated_at = NOW()
            WHERE I_ID = ?";

        $stmt = $this->inventoryDB->prepare($sql);

        return $stmt->execute([
            $categ_ID,
            $item_name,
            $item_type,
            $item_brand,
            $quantity,
            $threshold,
            $item_supplier,
            $defects,
            $serial_number,
            $date_received,
            $collected_by,
            $id
        ]);
    }

    public function getGroupedInventory($categoryId = null)
    {
        $sql = "SELECT 
                i.item_name,
                i.categ_ID,
                c.category_name,
                SUM(i.Quantity) AS TotalQuantity, 
                MAX(i.Threshold) AS Threshold,
                MAX(i.created_at) AS latest_created
            FROM inventory_items i
            LEFT JOIN inventory_categories c ON i.categ_ID = c.IC_ID
            WHERE 1=1";

        if ($categoryId) {
            $sql .= " AND i.categ_ID = :catID";
        }

        $sql .= " GROUP BY i.item_name, i.categ_ID, c.category_name";

        $sql .= " ORDER BY (SUM(i.Quantity) <= 0) DESC, latest_created DESC";

        $stmt = $this->inventoryDB->prepare($sql);

        if ($categoryId) {
            $stmt->execute(['catID' => $categoryId]);
        } else {
            $stmt->execute();
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDepletedItems()
    {
        $sql = "SELECT 
                    i.item_name,
                    i.categ_ID,
                    c.category_name,
                    SUM(i.Quantity) AS TotalQuantity,
                    MAX(i.Threshold) AS Threshold,
                    MAX(i.created_at) AS latest_created
                FROM inventory_items i
                LEFT JOIN inventory_categories c ON i.categ_ID = c.IC_ID
                WHERE i.Quantity <= 0
                GROUP BY i.item_name, i.categ_ID, c.category_name
                ORDER BY latest_created DESC";

        $stmt = $this->inventoryDB->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createCategory($name, $desc, $userId)
    {
        $sql = "INSERT INTO inventory_categories (category_name, IC_Desc, created_at, created_by)
            VALUES (?, ?, NOW(), ?)";
        $stmt = $this->inventoryDB->prepare($sql);
        $success = $stmt->execute([$name, $desc, $userId]);

        if ($success) {
            $newId = $this->inventoryDB->lastInsertId();
            $this->logActivity($userId, "Created Category: $name", $newId, "Inventory");
        }
        return $success;
    }

    public function getCategoryNameById($id)
    {
        $sql = "SELECT category_name FROM inventory_categories WHERE IC_ID = :id";
        $stmt = $this->inventoryDB->prepare($sql);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result['category_name'] : 'Unknown Category';
    }

    public function updateCategory($id, $name, $desc, $color, $userId)
    {
        $sql = "UPDATE inventory_categories
            SET category_name = ?, IC_Desc = ?, category_color = ?
            WHERE IC_ID = ?";
        $stmt = $this->inventoryDB->prepare($sql);
        $success = $stmt->execute([$name, $desc, $color, $id]);

        if ($success) {
            // Log the activity
            $this->logActivity($userId, "Updated Category: $name", $id, "Inventory");
        }
        return $success;
    }

    public function getInventoryCategories()
    {
        $stmt = $this->inventoryDB->query("SELECT * FROM inventory_categories ORDER BY category_name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getInventoryTypes()
    {
        $stmt = $this->inventoryDB->query("SELECT * FROM inventory_type ORDER BY type ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createInventoryItem($data)
    {
        $sql = "INSERT INTO inventory_items (
                categ_ID, item_type, item_name, item_brand,
                Quantity, Threshold, item_supplier, Defects,
                Serial_number, date_received, created_at, created_by
            ) VALUES (
                :categ, :type, :name, :brand,
                :qty, :threshold, :supplier, :defects,
                :serial, :received, NOW(), :user
            )";

        $stmt = $this->inventoryDB->prepare($sql);
        return $stmt->execute([
            'categ' => $data['categ_id'],
            'type' => $data['type_id'],
            'name' => $data['name'],
            'brand' => $data['brand'],
            'qty' => $data['quantity'],
            'threshold' => $data['threshold'],
            'supplier' => $data['supplier'],
            'defects' => $data['defects'],
            'serial' => $data['serial'],
            'received' => $data['received'],
            'user' => $_SESSION['user_id']
        ]);
    }

    // "transaction" so when a user request an item remove or subtract item in inventory
    public function issueInventoryFromTicket($itemId, $quantity, $ticketId, $receivedBy, $userId)
    {
        try {
            $this->inventoryDB->beginTransaction();

            // check if stock
            $check = $this->inventoryDB->prepare("SELECT Quantity FROM inventory_items WHERE I_ID = ?");
            $check->execute([$itemId]);
            $item = $check->fetch();

            if (!$item || $item['Quantity'] < $quantity) {
                throw new Exception("Insufficient stock or item not found.");
            }

            // subtraction logic
            $sql1 = "UPDATE inventory_items SET Quantity = Quantity - :qty WHERE I_ID = :iid";
            $stmt1 = $this->inventoryDB->prepare($sql1);
            $stmt1->execute(['qty' => $quantity, 'iid' => $itemId]);

            // move to tracker once subtracted
            $sql2 = "INSERT INTO inventory_tracker
                 (I_ID, Quantity, reference_ticket, Input_by, Received_by, date_received)
                 VALUES (:iid, :qty, :ref, :input, :recv, NOW())";
            $stmt2 = $this->inventoryDB->prepare($sql2);
            $stmt2->execute([
                'iid' => $itemId,
                'qty' => $quantity,
                'ref' => $ticketId,
                'input' => $userId,
                'recv' => $receivedBy
            ]);

            // Update Ticket
            $sql3 = "UPDATE chams_ticketing.tickets SET issued_item_id = :iid, issued_qty = :qty WHERE T_ID = :tid";
            $stmt3 = $this->inventoryDB->prepare($sql3);
            $stmt3->execute(['iid' => $itemId, 'qty' => $quantity, 'tid' => $ticketId]);

            // logs for act log
            $this->logActivity($userId, "Issued $quantity units for Ticket #$ticketId", $itemId, 'Inventory');

            $this->inventoryDB->commit();
            return true;
        } catch (Exception $e) {
            $this->inventoryDB->rollBack();
            die("Database Error: " . $e->getMessage());
            return false;
        }
    }

    public function getAllInventoryTracker($filters = [])
    {
        $sql = "SELECT it.IT_ID, it.I_ID, it.Quantity AS tracker_qty, 
                    it.reference_ticket, it.date_received AS date_delivered,
                    it.Received_by,
                    i.item_name, i.item_brand, i.item_supplier, 
                    i.Serial_number, i.Defects,
                    CONCAT(u_input.FN, ' ', u_input.LN) AS input_by_name,
                    /* THIS IS THE KEY: Linking D to u_rec, not u_input */
                    d.Dept_Name AS Dept_Name 
                FROM inventory_tracker it
                LEFT JOIN inventory_items i ON it.I_ID = i.I_ID
                /* Join 1: The Admin who typed it in */
                LEFT JOIN chams_users.users u_input ON it.Input_by = u_input.U_ID
                /* Join 2: The User who received the item (ID 3 in your example) */
                LEFT JOIN chams_users.users u_rec ON it.Received_by = u_rec.U_ID
                /* Join 3: The Department belonging to the Receiver */
                LEFT JOIN chams_users.departments d ON u_rec.Dept_ID = d.D_ID
                WHERE 1=1";

        if (!empty($filters['ticket'])) {
            $sql .= " AND it.reference_ticket = :ref";
        }

        $sql .= " ORDER BY it.date_received DESC";

        $stmt = $this->inventoryDB->prepare($sql);
        $params = [];
        if (!empty($filters['ticket'])) {
            $params['ref'] = $filters['ticket'];
        }

        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // login logs
    public function logLogin($user_id, $status)
    {
        try {
            $stmt = $this->logsDB->prepare("
            INSERT INTO login_logs (U_ID, login_time, stat)
            VALUES (:user, NOW(), :stat)
        ");
            return $stmt->execute([
                'user' => $user_id,
                'stat' => $status
            ]);
        } catch (PDOException $e) {
            error_log("failed: " . $e->getMessage());
            return false;
        }
    }

    public function logLogout($user_id)
    {
        // idk if i can put this in login if so go ahead
        // this is to get the recent logged in that has "!= 'logout" meaning no logout yet
        $stmt = $this->logsDB->prepare("
        UPDATE login_logs
        SET logout_time = NOW(), stat = 'Logout'
        WHERE U_ID = :id AND stat != 'Logout'
        ORDER BY login_time DESC LIMIT 1
    ");
        return $stmt->execute(['id' => $user_id]);
    }

    //action logins
    public function logAction($user_id, $action)
    {
        $stmt = $this->logsDB->prepare("
            INSERT INTO act_logs (U_ID, act, created_at)
            VALUES (:user, :action, NOW())
        ");
        return $stmt->execute([
            'user' => $user_id,
            'action' => $action
        ]);
    }

    // filter type shi
    public function getTicketFilterData()
    {
        $sql = "
        SELECT DISTINCT
            d.Dept_Name,
            CONCAT(u.FN, ' ', u.LN) AS full_name,
            IFNULL(t.Status, 'Unresolved') AS Status
        FROM tickets t
        LEFT JOIN chams_users.users u ON t.Created_By = u.U_ID
        LEFT JOIN chams_users.departments d ON u.Dept_ID = d.D_ID
        ORDER BY d.Dept_Name ASC, full_name ASC
    ";

        $stmt = $this->ticketDB->query($sql);

        $departments = ["All"];
        $deptGroups = ["All" => ["All"]];
        $allNames = ["All"];
        $status = ["ALL"];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $dept = $row['Dept_Name'] ?? 'Unknown';
            $name = $row['full_name'];
            $stat = !empty($row['Status']) ? $row['Status'] : 'Unresolved';

            if (!in_array($dept, $departments)) {
                $departments[] = $dept;
            }

            if (!isset($deptGroups[$dept])) {
                $deptGroups[$dept] = ["All"];
            }

            if (!in_array($name, $deptGroups[$dept])) {
                $deptGroups[$dept][] = $name;
            }

            if (!in_array($name, $allNames)) {
                $allNames[] = $name;
            }

            if (!in_array($stat, $status)) {
                $status[] = $stat;
            }
        }

        $deptGroups["All"] = $allNames;

        return [
            'departments' => $departments,
            'name' => $allNames,
            'groups' => $deptGroups,
            'status' => $status
        ];
    }

    public function getFilterTypes($filterId)
    {
        try {
            switch ($filterId) {
                case 'inventory':
                    $stmt = $this->inventoryDB->query("SELECT category_name FROM inventory_categories ORDER BY category_name ASC");
                    break;
                case 'ticketing':
                    $stmt = $this->ticketDB->query("SELECT DISTINCT categ_name FROM ticket_categories ORDER BY categ_name ASC");
                    break;
                case 'actLog':
                    $stmt = $this->logsDB->query("SELECT DISTINCT module FROM act_logs ORDER BY module ASC");
                    break;
                default:
                    return ["All"];
            }

            $results = $stmt->fetchAll(PDO::FETCH_COLUMN);
            return array_merge(["All"], $results);

        } catch (PDOException $e) {
            return ["All", "Error fetching types"];
        }
    }

    public function getFilteredTracker($filters = [], $page = 1, $limit = 5)
    {
        $sql = "SELECT it.*, c.category_name, 
                it.Quantity AS tracker_qty,
                it.date_received AS date_delivered,
                i.item_name, i.item_brand, i.item_supplier,
                i.Serial_number, i.Defects,
                CONCAT(u_input.FN, ' ', u_input.LN) AS input_by_name,
                d_rec.Dept_Name
            FROM inventory_tracker it
            LEFT JOIN inventory_items i ON it.I_ID = i.I_ID
            LEFT JOIN chams_users.users u_input ON it.Input_by = u_input.U_ID
            LEFT JOIN chams_users.users u_rec ON it.Received_by = u_rec.U_ID
            LEFT JOIN chams_users.departments d_rec ON u_rec.Dept_ID = d_rec.D_ID
            LEFT JOIN inventory_categories c ON i.categ_ID = c.IC_ID
            WHERE 1=1";

        $params = [];

        if (!empty($filters['department']) && $filters['department'] !== 'All') {
            $sql .= " AND d_rec.Dept_Name = :dept";
            $params['dept'] = $filters['department'];
        }

        if (!empty($filters['name']) && $filters['name'] !== 'All') {
            $sql .= " AND CONCAT(u_rec.FN, ' ', u_rec.LN) = :name";
            $params['name'] = $filters['name'];
        }

        if (!empty($filters['type']) && $filters['type'] !== 'All') {
            $sql .= " AND c.category_name = :type";
            $params['type'] = $filters['type'];
        }

        if (!empty($filters['item']) && $filters['item'] !== 'All') {
            $sql .= " AND c.category_name = :item";
            $params['item'] = $filters['item'];
        }

        if (!empty($filters['date']) && $filters['date'] !== 'All') {
            $sql .= " AND DATE(it.date_received) = :date";
            $params['date'] = $filters['date'];
        }

        $sort = $this->getSortSettings();
        $sql .= " ORDER BY it.date_received " . $sort['direction'];

        // Pagination
        $offset = ($page - 1) * $limit;
        $sql .= " LIMIT :limit OFFSET :offset";

        $stmt = $this->inventoryDB->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindValue(":$key", $val);
        }

        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTrackerFilters()
    {
        $filters = [];

        $stmt = $this->inventoryDB->query("SELECT category_name FROM inventory_categories ORDER BY category_name ASC");
        $filters['item'] = array_merge(["All"], $stmt->fetchAll(PDO::FETCH_COLUMN));

        $stmt = $this->inventoryDB->query("SELECT DISTINCT item_supplier FROM inventory_items WHERE item_supplier IS NOT NULL ORDER BY item_supplier ASC");
        $filters['supplier'] = array_merge(["All"], $stmt->fetchAll(PDO::FETCH_COLUMN));

        $filters['defects'] = ["All", "Yes", "No"];

        return $filters;
    }

    public function getPaginationData($filterId, $currentPage = 1, $itemsPerPage = 5, $role = null, $user_id = null, $filters = [])
    {
        $params = [];
        $totalItems = 0;
        $stmt = null;
        $status = $filters['status'] ?? 'All';

        switch ($filterId) {
            case 'inventory':
                $sql = "SELECT COUNT(*) as total
                    FROM inventory_items i
                    LEFT JOIN chams_users.users u ON i.created_by = u.U_ID
                    LEFT JOIN chams_users.departments d ON u.Dept_ID = d.D_ID
                    LEFT JOIN inventory_categories c ON i.categ_ID = c.IC_ID
                    WHERE 1=1";

                if (!empty($filters['department']) && $filters['department'] !== 'All') {
                    $sql .= " AND d.Dept_Name = :dept";
                    $params['dept'] = $filters['department'];
                }
                if (!empty($filters['name']) && $filters['name'] !== 'All') {
                    $sql .= " AND CONCAT(u.FN, ' ', u.LN) = :name";
                    $params['name'] = $filters['name'];
                }
                if (!empty($filters['type']) && $filters['type'] !== 'All') {
                    $sql .= " AND c.category_name = :type";
                    $params['type'] = $filters['type'];
                }
                if (!empty($filters['date']) && $filters['date'] !== 'All') {
                    $sql .= " AND DATE(i.created_at) = :date";
                    $params['date'] = $filters['date'];
                }

                $stmt = $this->inventoryDB->prepare($sql);
                break;

            case 'actLog':
                $sql = "SELECT COUNT(*) as total FROM act_logs a
                    LEFT JOIN chams_users.users u ON a.U_ID = u.U_ID
                    WHERE 1=1";

                if (!empty($filters['type']) && $filters['type'] !== 'All') {
                    $sql .= " AND a.module = :module";
                    $params['module'] = $filters['type'];
                }
                if (!empty($filters['name']) && $filters['name'] !== 'All') {
                    $sql .= " AND CONCAT(u.FN, ' ', u.LN) = :name";
                    $params['name'] = $filters['name'];
                }

                $stmt = $this->logsDB->prepare($sql);
                break;

            case 'tracker':
                $sql = "SELECT COUNT(*) as total
                    FROM inventory_tracker it
                    LEFT JOIN chams_users.users u ON it.Received_by = u.U_ID 
                    LEFT JOIN chams_users.departments d ON u.Dept_ID = d.D_ID
                    LEFT JOIN inventory_items i ON it.I_ID = i.I_ID
                    LEFT JOIN inventory_categories c ON i.categ_ID = c.IC_ID
                    WHERE 1=1";

                if (!empty($filters['department']) && $filters['department'] !== 'All') {
                    $sql .= " AND d.Dept_Name = :dept";
                    $params['dept'] = $filters['department'];
                }

                if (!empty($filters['item']) && $filters['item'] !== 'All') {
                    $sql .= " AND c.category_name = :cat_name";
                    $params['cat_name'] = $filters['item'];
                }

                if (!empty($filters['date']) && $filters['date'] !== '') {
                    $sql .= " AND DATE(it.date_received) = :date";
                    $params['date'] = $filters['date'];
                }

                $stmt = $this->inventoryDB->prepare($sql);
                break;

            case 'maintenance':
                $sql = "SELECT COUNT(*) as total 
                        FROM maintenance m
                        LEFT JOIN chams_users.departments d ON m.Dept_ID = d.D_ID
                        WHERE 1=1";

                if (!empty($filters['department']) && $filters['department'] !== 'All') {
                    if ($filters['department'] === 'N/A') {
                        $sql .= " AND (m.Dept_ID IS NULL OR d.Dept_Name IS NULL)";
                    } else {
                        $sql .= " AND d.Dept_Name = :dept";
                        $params['dept'] = $filters['department'];
                    }
                }

                if (!empty($filters['date']) && $filters['date'] !== 'All') {
                    $sql .= " AND DATE(m.created_at) = :date";
                    $params['date'] = $filters['date'];
                }

                if ($filters['status'] === 'Not Scheduled') {
                    $sql .= " AND m.Status IS NULL";
                } elseif (!empty($filters['status']) && $filters['status'] !== 'All') {
                    $sql .= " AND (m.Status) = :maintenance_status";
                    $params['maintenance_status'] = $filters['status'];
                }

                $stmt = $this->logsDB->prepare($sql);
                break;

            default: // ticketing
                $sql = "SELECT COUNT(*) as total
                    FROM tickets t
                    LEFT JOIN chams_users.users u ON t.Created_By = u.U_ID
                    LEFT JOIN chams_users.users s ON t.Assigned_To = s.U_ID
                    LEFT JOIN chams_users.departments d ON u.Dept_ID = d.D_ID
                    LEFT JOIN ticket_categories c ON t.t_type = c.TC_ID
                    WHERE 1=1";

                if ($role == 2) {
                    $sql .= " AND (t.Assigned_To = :uid OR t.Assigned_To IS NULL)";
                    $params['uid'] = $user_id;
                } elseif ($role != 1) {
                    $sql .= " AND t.Created_By = :uid";
                    $params['uid'] = $user_id;
                }

                if (!empty($filters['department']) && $filters['department'] !== 'All') {
                    $sql .= " AND d.Dept_Name = :dept_name";
                    $params['dept_name'] = $filters['department'];
                }

                if (!empty($filters['name']) && $filters['name'] !== 'All') {
                    $sql .= " AND CONCAT(u.FN, ' ', u.LN) = :creator_name";
                    $params['creator_name'] = $filters['name'];
                }

                if (!empty($filters['type']) && $filters['type'] !== 'All') {
                    $sql .= " AND c.categ_name = :ticket_type";
                    $params['ticket_type'] = $filters['type'];
                }

                if (!empty($filters['date']) && $filters['date'] !== 'All') {
                    $sql .= " AND DATE(t.created_at) = :selected_date";
                    $params['selected_date'] = $filters['date'];
                }

                if (!empty($filters['status']) && $filters['status'] !== 'All') {
                    $sql .= " AND t.Status = :status";
                    $params['status'] = $filters['status'];
                }

                if (isset($filters['unassigned']) && $filters['unassigned'] == '1') {
                    $sql .= " AND (t.Assigned_To IS NULL OR t.Assigned_To = 0 OR t.Assigned_To = '')";
                }

                if (isset($filters['overdue']) && $filters['overdue'] == '1') {
                    $sql .= " AND due_date < NOW() ";
                }

                if (!empty($filters['priority']) && $filters['priority'] !== 'All') {
                    $sql .= " AND t.Priority = :priority";
                    $params['priority'] = $filters['priority'];
                }

                $stmt = $this->ticketDB->prepare($sql);
                break;
        }
        if ($stmt) {
            $stmt->execute($params);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $totalItems = (int) ($result['total'] ?? 0);
        }

        $totalPages = max(1, ceil($totalItems / $itemsPerPage));

        if ($totalItems == 0) {
            $start = 0;
            $end = 0;
        } else {
            $start = ($currentPage - 1) * $itemsPerPage + 1;
            $end = min($currentPage * $itemsPerPage, $totalItems);
        }

        return [
            'start' => $start,
            'end' => $end,
            'total' => $totalItems,
            'totalPages' => $totalPages,
            'display' => "$start-$end of $totalItems"
        ];
    }

    public function getSortSettings()
    {
        $allowed = ['newest', 'oldest'];
        $current = $_GET['sort'] ?? 'newest';

        if (!in_array($current, $allowed)) {
            $current = 'newest';
        }

        if ($current === 'oldest') {
            return [
                'current' => 'oldest',
                'next' => 'newest',
                'label' => 'Oldest ▲',
                'direction' => 'ASC'
            ];
        }

        // default: newest
        return [
            'current' => 'newest',
            'next' => 'oldest',
            'label' => 'Newest ▼',
            'direction' => 'DESC'
        ];
    }

    public function getCategoryIcon($categoryName)
    {
        $name = strtolower($categoryName ?? '');

        if (str_contains($name, 'computer') || str_contains($name, 'laptop'))
            return 'fas fa-desktop';
        if (str_contains($name, 'mouse') || str_contains($name, 'keyboard') || str_contains($name, 'peripheral'))
            return 'fas fa-mouse';
        if (str_contains($name, 'network') || str_contains($name, 'router'))
            return 'fas fa-network-wired';
        if (str_contains($name, 'storage') || str_contains($name, 'hard drive'))
            return 'fas fa-hdd';
        if (str_contains($name, 'monitor') || str_contains($name, 'screen'))
            return 'fas fa-tv';
        if (str_contains($name, 'printer'))
            return 'fas fa-print';

        // Default icon
        return 'fas fa-folder';
    }

    // activity Logs
    public function getActivityLogs($filters = [], $page = 1, $limit = 5)
    {
        $sql = "SELECT u.FN, u.LN, a.A_ID, a.U_ID, a.act, a.module, a.ref_ID, a.created_at
            FROM act_logs a
            LEFT JOIN chams_users.users u ON a.U_ID = u.U_ID
            WHERE 1=1";
        $params = [];

        // Filter Logic
        if (!empty($filters['role']) && $filters['role'] !== 'All') {
            $sql .= " AND u.Role = :role";
            $params['role'] = $filters['role'];
        }
        if (!empty($filters['type']) && $filters['type'] !== 'All') {
            $sql .= " AND a.module = :module";
            $params['module'] = $filters['type'];
        }
        if (!empty($filters['name']) && $filters['name'] !== 'All') {
            $sql .= " AND CONCAT(u.FN, ' ', u.LN) = :name";
            $params['name'] = $filters['name'];
        }

        $sort = $this->getSortSettings();
        $sql .= " ORDER BY a.A_ID " . $sort['direction'];

        $offset = ($page - 1) * $limit;
        $sql .= " LIMIT :limit OFFSET :offset";

        $stmt = $this->logsDB->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindValue(":$key", $val);
        }

        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function logActivity($u_id, $act, $ref, $module)
    {
        $sql = "INSERT INTO act_logs (U_ID, act, ref_ID, module, created_at)
            VALUES (:u_id, :act, :ref, :module, NOW())";

        $stmt = $this->logsDB->prepare($sql);
        return $stmt->execute([
            ':u_id' => $u_id,
            ':act' => $act,
            ':ref' => $ref,
            ':module' => $module
        ]);
    }

    public function getStaffNameById($id)
    {
        $stmt = $this->usersDB->prepare("SELECT FN, LN FROM users WHERE U_ID = ?");
        $stmt->execute([$id]);
        $staff = $stmt->fetch(PDO::FETCH_ASSOC);
        return $staff ? $staff['FN'] . " " . $staff['LN'] : "Unknown Staff";
    }

    // search 
    // not working so im bailing on this because of time constraints
    // public function globalSearch($term) {
    //     $term = "%$term%";
    //     $results = [];

    //     // Search Tickets
    //     $stmt = $this->inventoryDB->prepare("
    //         SELECT 
    //             T_ID as id, 
    //             'Ticket' as type, 
    //             Title as title 
    //         FROM chams_ticketing.tickets 
    //         WHERE Title LIKE ? 
    //             OR T_description LIKE ? 
    //             OR ticket_num LIKE ?

    //         LIMIT 3
    //     ");
    //     $stmt->execute([$term, $term, $term]);
    //     $results['tickets'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //     // Search inventory
    //     $stmt = $this->inventoryDB->prepare("
    //         SELECT
    //             I_ID as id,
    //             'Asset' as type, 
    //             item_name as title 
    //         FROM chams_inventory.inventory_items
    //         WHERE item_name LIKE ? 
    //             OR Serial_number LIKE ? 
    //         LIMIT 3
    //     ");

    //     $stmt->execute([$term, $term]);
    //     $results['assets'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //     return $results;
    // }

    // notification logs
    public function createNotification($userId, $message, $type = null, $refId = null)
    {
        $stmt = $this->logsDB->prepare("
            INSERT INTO notifications (user_id, message, type, ref_id)
            VALUES (:uid, :msg, :type, :ref)
        ");

        return $stmt->execute([
            'uid' => $userId,
            'msg' => $message,
            'type' => $type,
            'ref' => $refId
        ]);
    }

    public function getUserNotifications($userId)
    {
        $stmt = $this->logsDB->prepare("
            SELECT * FROM notifications
            WHERE user_id = :uid AND is_read = 0
            ORDER BY created_at DESC
            LIMIT 10
        ");
        $stmt->execute(['uid' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActiveNotifications($userId)
    {
        $stmt = $this->logsDB->prepare("
            SELECT n.* FROM notifications n
            LEFT JOIN notification_dismissals d 
                ON n.N_ID = d.notification_id AND d.user_id = :uid
            WHERE n.user_id = :uid 
                AND d.notification_id IS NULL
            ORDER BY n.created_at DESC
        ");
        $stmt->execute(['uid' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function dismissNotification($notifId, $userId)
    {
        $stmt = $this->logsDB->prepare("
            INSERT IGNORE INTO notification_dismissals (notification_id, user_id) 
            VALUES (:nid, :uid)
        ");
        return $stmt->execute([
            'nid' => $notifId,
            'uid' => $userId
        ]);
    }

    public function markAllNotifsRead($userId)
    {
        $sql = "INSERT IGNORE INTO notification_dismissals (notification_id, user_id)
                SELECT N_ID, :uid FROM notifications
                WHERE user_id = :uid";

        $stmt = $this->logsDB->prepare($sql);
        return $stmt->execute(['uid' => $userId]);
    }

    // maintenance logs
    public function resolveAndScheduleMaintenance($m_id, $asset_id, $m_type, $interval_string)
    {
        try {
            $this->usersDB->beginTransaction();

            // 1. Mark the current log as Resolved
            $stmt1 = $this->usersDB->prepare("UPDATE maintenance SET Status = 'Resolved', resolved_at = NOW() WHERE M_ID = ?");
            $stmt1->execute([$m_id]);

            // 2. Calculate the next date (e.g., '+3 months')
            $nextDate = date('Y-m-d H:i:s', strtotime($interval_string));

            // 3. Create the NEW cycle entry
            $stmt2 = $this->usersDB->prepare("
            INSERT INTO maintenance_logs (Asset_ID, M_type, Status, next_maintenance, Priority)
            SELECT Asset_ID, M_type, 'Unresolved', ?, Priority
            FROM maintenance_logs WHERE M_ID = ?
        ");
            $stmt2->execute([$nextDate, $m_id]);

            $this->usersDB->commit();
            return true;
        } catch (Exception $e) {
            $this->usersDB->rollBack();
            return false;
        }
    }

    public function getMaintenanceById($id)
    {
        $sql = "SELECT * FROM maintenance WHERE M_ID = ?";
        $stmt = $this->logsDB->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteMaintenanceById($id)
    {
        $sql = "DELETE FROM maintenance WHERE M_ID = :id";
        $stmt = $this->logsDB->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function updateMaintenance($id, $asset, $dept, $type, $desc, $priority, $status, $nextDate)
    {
        $sql = "UPDATE maintenance 
            SET Asset_name = ?, 
                Dept_ID = ?,
                M_type = ?, 
                `desc` = ?, 
                Priority = ?, 
                Status = ?, 
                next_m = ?
            WHERE M_ID = ?";

        $stmt = $this->logsDB->prepare($sql);
        return $stmt->execute([$asset, $dept, $type, $desc, $priority, $status, $nextDate, $id]);
    }

    public function createMaintenance($asset, $dept, $type, $desc, $priority, $status, $nextDate)
    {
        $sql = "INSERT INTO maintenance 
            (Asset_name, Dept_ID, M_type, `desc`, Priority, Status, next_m, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";

        $stmt = $this->logsDB->prepare($sql);
        return $stmt->execute([$asset, $dept, $type, $desc, $priority, $status, $nextDate]);
    }

    public function getMaintenanceLogs($filters = [], $page = 1, $limit = 5)
    {
        $sql = "SELECT m.*, d.Dept_Name
            FROM CHAMS_LOGS.maintenance m
            LEFT JOIN CHAMS_USERS.departments d ON m.Dept_ID = d.D_ID
            WHERE 1=1";

        $params = [];

        if (!empty($filters['department']) && $filters['department'] !== 'All') {
            if ($filters['department'] === 'N/A') {
                $sql .= " AND (m.Dept_ID IS NULL OR d.Dept_Name IS NULL)";
            } else {
                $sql .= " AND d.Dept_Name = :dept";
                $params['dept'] = $filters['department'];
            }
        }

        if (!empty($filters['status']) && $filters['status'] !== 'All') {
            if ($filters['status'] === 'Not Scheduled') {
                $sql .= " AND m.Status IS NULL";
            } else {
                $sql .= " AND m.Status = :status";
                $params['status'] = $filters['status'];
            }
        }

        if (!empty($filters['type']) && $filters['type'] !== 'All') {
            $sql .= " AND m.M_type = :type";
            $params['type'] = $filters['type'];
        }

        if (!empty($filters['date']) && $filters['date'] !== 'All') {
            $sql .= " AND DATE(m.created_at) = :date";
            $params['date'] = $filters['date'];
        }

        $sort = $this->getSortSettings();
        $sql .= " ORDER BY m.created_at " . $sort['direction'];

        $offset = ($page - 1) * $limit;
        $sql .= " LIMIT :limit OFFSET :offset";

        $stmt = $this->inventoryDB->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindValue(":$key", $val);
        }

        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMaintenanceFilterData()
    {
        $sql = "
            SELECT DISTINCT 
                IFNULL(d.Dept_Name, 'N/A') AS Dept_Name,
                IFNULL(m.Status, 'Not Scheduled') AS Status
            FROM maintenance m
            LEFT JOIN chams_users.departments d ON m.Dept_ID = d.D_ID
            ORDER BY Dept_Name ASC
        ";

        $stmt = $this->logsDB->query($sql);

        $departments = ["All"];

        $status = ["ALL"];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $dept = !empty($row['Dept_Name']) ? $row['Dept_Name'] : 'N/A';
            $stat = $row['Status'];


            if (!in_array($dept, $departments)) {
                $departments[] = $dept;
            }

            if (!in_array($stat, $status)) {
                $status[] = $stat;
            }
        }

        return [
            'departments' => $departments,
            'status' => $status
        ];
    }
}

// dito ko nalang lagay para isang file lng
// for "tile" view para hindi date ex: 2026-12-25 ung lumabas
function timeAgo($datetime)
{
    date_default_timezone_set('Asia/Manila');
    $timestamp = strtotime($datetime);
    $diff = time() - $timestamp;

    if ($diff < 60)
        return "Just now";
    if ($diff < 3600)
        return floor($diff / 60) . " mins ago";
    if ($diff < 86400)
        return floor($diff / 3600) . " hrs ago";
    if ($diff < 172800)
        return "Yesterday";

    return date("M d, Y", $timestamp);
}