<?php if ($mode === 'maintenance'): ?>
    <form action="../Config/updateAction.php" method="POST" style="width: 100%;">
        <input type="hidden" name="id" value="<?= $id ?>">
        <input type="hidden" name="mode" value="maintenance">

        <div class="content">
            <div class="page-header" id="pageHeadText" style="padding: 1.3%;">
                <i class="fas fa-edit"></i>
                EDITING MAINTENANCE #<?= htmlspecialchars($data['M_ID']) ?>
                <div class="custom-select" onclick="toggleInventorySelect(this)">

                    <i class="fas fa-ellipsis-v"></i>

                    <div class="dropdown-menu">
                        <div class="dropdown-item delete-item" onclick="confirmDeleteMaintenance('<?= $data['M_ID'] ?>')">
                            <i class="fas fa-trash-alt"></i> Delete Maintenance
                        </div>
                    </div>
                </div>
            </div>

            <div class="info-grid">
                <div>
                    <div class="grid-row">
                        <span class="label">Asset Name:</span>
                        <input type="text" name="asset_name" class="value"
                            value="<?= htmlspecialchars($data['Asset_name'] ?? '') ?>">
                    </div>

                    <div class="grid-row">
                        <span class="label">Created at:</span>
                        <span class="value">
                            <?= date('M d, Y | h:i A', strtotime($data['created_at'])) ?>
                        </span>
                    </div>
                </div>

                <div>
                    <div class="grid-row">
                        <span class="label">Maintenance Type:</span>
                        <select name="m_type" class="value">
                            <?php foreach (['Preventive', 'Predictive', 'Corrective'] as $type): ?>
                                <option value="<?= $type ?>" <?= (($data['M_type'] ?? '') == $type) ? 'selected' : '' ?>>
                                    <?= $type ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="grid-row">
                        <span class="label">Next Maintenance:</span>
                        <select name="interval" class="value">
                            <option value="">Unassign</option>
                            <option value="+1 month">Monthly</option>
                            <option value="+3 months">Quarterly</option>
                            <option value="+6 months">Semi-Annual</option>
                            <option value="+1 year">Annual</option>
                        </select>
                    </div>
                </div>
                <?php $departments = $q->getDepartments(); ?>
                <div class="grid-row full-span">
                    <span class="label">Department:</span>
                    <select name="Dept_ID" class="value">
                        <?php foreach ($departments as $dept): ?>
                            <option value="<?= $dept['D_ID'] ?>" <?= ($data['Dept_ID'] == $dept['D_ID']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($dept['Dept_Name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="pageHeadText" style="margin-bottom: 2%; padding-bottom: 2%;">
                <span class="message-label">Maintenance Description:</span>
                <div class="form-group">
                    <textarea name="description" class="message-box"
                        rows="6"><?= htmlspecialchars($data['desc'] ?? '') ?></textarea>
                </div>

                <div class="status-section">
                    <div class="status-row">
                        <span class="status-label">Priority:</span>
                        <select name="priority" class="badge <?= strtolower($data['Priority'] ?? 'unassigned') ?>"
                            onchange="updateBadgeColor(this)">
                            <?php foreach (['N/A', 'Low', 'Medium', 'High'] as $prio): ?>
                                <option value="<?= $prio ?>" <?= (($data['Priority'] ?? '') == $prio) ? 'selected' : '' ?>>
                                    <?= $prio ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="status-row">
                        <span class="status-label">Status:</span>
                        <select name="status" class="badge <?= strtolower($data['Status'] ?? 'unassigned') ?>"
                            onchange="updateBadgeColor(this)">
                            <?php foreach (['N/A', 'Scheduled', 'Ongoing', 'Resolved'] as $stat): ?>
                                <option value="<?= $stat ?>" <?= (($data['Status'] ?? '') == $stat) ? 'selected' : '' ?>>
                                    <?= $stat ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-footer">
                    <div class="actions" style="margin-top: 5%;">
                        <a href="tileView.php?id=<?= $id ?>&mode=maintenance" class="btn cancel">
                            Cancel
                        </a>
                        <button type="submit" class="btn download">
                            SAVE CHANGES <i class="fas fa-save"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

<?php elseif ($mode === 'inventory'): ?>
    <form action="../Config/updateAction.php" method="POST" style="width: 100%;">
        <input type="hidden" name="id" value="<?= $id ?>">
        <input type="hidden" name="mode" value="inventory">

        <div class="content">
            <div class="page-header" id="pageHeadText" style="padding: 1.3%;">
                <i class="fas fa-edit"></i>
                EDITING ITEM: <?= htmlspecialchars(strtoupper($data['item_name'] ?? '')) ?>
            </div>

            <div class="info-grid">
                <div>
                    <div class="grid-row">
                        <span class="label">Item Name:</span>
                        <input type="text" name="item_name" class="value"
                            value="<?= htmlspecialchars($data['item_name'] ?? '') ?>">
                    </div>
                    <div class="grid-row">
                        <span class="label">Item Brand:</span>
                        <input type="text" name="item_brand" class="value"
                            value="<?= htmlspecialchars($data['item_brand'] ?? '') ?>">
                    </div>
                    <div class="grid-row">
                        <span class="label">Item Type:</span>
                        <select name="categ_id" class="value">
                            <?php $inv_categories = $q->getInventoryCategories();
                            foreach ($inv_categories as $cat):
                                $selected = (($data['categ_ID'] ?? '') == $cat['IC_ID']) ? 'selected' : ''; ?>

                                <option value="<?= $cat['IC_ID'] ?>" <?= $selected ?>>
                                    <?= htmlspecialchars($cat['category_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div>
                    <div class="grid-row">
                        <span class="label">Supplier:</span>
                        <input type="text" name="supplier" id="supplier" class="value"
                            value="<?= htmlspecialchars($data['item_supplier'] ?? '') ?>" required>
                    </div>

                    <div class="grid-row">
                        <label for="quantity" class="label">Quantity</label>
                        <input type="number" name="quantity" id="quantity" class="value"
                            value="<?= htmlspecialchars($data['Quantity'] ?? 1) ?>" required>
                    </div>

                    <div class="grid-row">
                        <label for="threshold" class="label">Low Stock Threshold</label>
                        <input type="number" name="threshold" id="threshold" min="0" class="value"
                            value="<?= htmlspecialchars($data['Threshold'] ?? 2) ?>" required>
                    </div>
                </div>

            </div>

            <div class="status-section" id="pageHeadText">
                <div class="status-row">
                    <span class="status-label">Serial No.:</span>
                    <input type="text" name="serial" class="badge"
                        value="<?= htmlspecialchars($data['Serial_number'] ?? 'N/A') ?>" placeholder="Enter SN...">
                </div>
                <div class="status-row">
                    <span class="status-label">Date Received:</span>
                    <input type="datetime-local" name="date_received" class="badge assigned"
                        value="<?= !empty($data['date_received']) ? date('Y-m-d\TH:i', strtotime($data['date_received'])) : date('Y-m-d\TH:i') ?>">
                </div>

                <div class="status-row">
                    <span class="status-label">Defects:</span>
                    <?php
                    $defectClass = (($data['Defects'] ?? 'No') === 'Yes') ? 'high' : 'resolved';
                    ?>
                    <select name="defects" id="defectsSelect" class="badge <?= $defectClass ?>"
                        onchange="updateBadgeColor(this)" required>
                        <option value="No" <?= (($data['Defects'] ?? 'No') === 'No') ? 'selected' : '' ?>>No</option>
                        <option value="Yes" <?= (($data['Defects'] ?? '') === 'Yes') ? 'selected' : '' ?>>Yes</option>
                    </select>
                </div>
            </div>

            <div class="form-footer">
                <div class="actions">
                    <a href="tileView.php?id=<?= $id ?>&mode=inventory" class="btn cancel">Cancel</a>
                    <button type="submit" class="btn download">SAVE CHANGES</button>
                </div>
            </div>
        </div>
    </form>
<?php else: ?>
    <!-- Ticketing -->
    <form action="../Config/updateAction.php" method="POST" enctype="multipart/form-data" style="width: 100%;">
        <input type="hidden" name="id" value="<?= $id ?>">
        <input type="hidden" name="mode" value="ticketing">
        <div class="content">
            <div class="page-header" id="pageHeadText" style="padding: 1.3%;">
                <i class="fas fa-edit"></i> EDITING <?= htmlspecialchars(strtoupper($data['ticket_num'] ?? '')) ?>
                <div class="custom-select" onclick="toggleInventorySelect(this)">
                    <i class="fas fa-ellipsis-v"></i>
                    <div class="dropdown-menu">
                        <div class="dropdown-item delete-item"
                            onclick="confirmDelete('<?= htmlspecialchars($data['ticket_num'] ?? '') ?>', '<?= $id ?>')">
                            <i class="fas fa-trash-alt"></i> Delete Ticket
                        </div>
                    </div>
                </div>
            </div>

            <div class="info-grid">
                <div>
                    <div class="grid-row">
                        <span class="label">Applicant Name:</span>
                        <span
                            class="value"><?= htmlspecialchars(($data['creator_FN'] ?? '') . ' ' . ($data['creator_LN'] ?? '')) ?></span>
                    </div>
                    <div class="grid-row">
                        <span class="label">Category:</span>
                        <select name="type" id="type" class="value">
                            <?php
                            $categories = $q->getTicketCategories();
                            foreach ($categories as $cat):
                                $isSelected = (($data['t_type'] ?? '') == $cat['TC_ID']) ? 'selected' : '';
                                ?>
                                <option value="<?= $cat['TC_ID'] ?>" <?= $isSelected ?>>
                                    <?= htmlspecialchars($cat['categ_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!-- <div class="grid-row">
                        <span class="label">Title:</span>
                        <input type="text" name="title" class="value" value="<?= htmlspecialchars($data['Title'] ?? '') ?>" required>
                    </div> -->
                    <?php if (!empty($data['issued_item_id']) && $role === 1): ?>
                        <div class="grid-row">
                            <span class="label">Issued Item:</span>
                            <select name="issued_item_id" class="value" style="color: #28a745; font-weight: bold;">
                                <option value="">None / No Item Issued</option>
                                <?php
                                $allInventory = $q->getAllInventory(true);
                                foreach ($allInventory as $inv):
                                    $isSelected = (($data['issued_item_id'] ?? '') == $inv['I_ID']) ? 'selected' : '';
                                    ?>
                                    <option value="<?= $inv['I_ID'] ?>" <?= $isSelected ?>>
                                        <?= htmlspecialchars($inv['item_name']) ?> (Brand:
                                        <?= htmlspecialchars($inv['item_brand']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                </div>

                <div>
                    <div class="grid-row">
                        <span class="label">Department:</span>
                        <span class="value"><?= htmlspecialchars($data['dept_name'] ?? 'N/A') ?></span>
                    </div>

                    <div class="grid-row" id="subCategoryGroup">
                        <span class="label">Sub-Category:</span>
                        <select name="sub_type" id="sub_type" class="value">
                            <option value="">Unspecified</option>
                            <?php 
                            if (!empty($data['t_type'])) {
                                $subs = $q->getSubCategoriesByCatId($data['t_type']);
                                foreach ($subs as $sub): 
                                    $isSubSelected = ($data['sub_type_id'] == $sub['sub_id']) ? 'selected' : '';
                                    ?>
                                    <option value="<?= $sub['sub_id'] ?>" <?= $isSubSelected ?>><?= htmlspecialchars($sub['sub_name']) ?></option>
                                <?php endforeach; 
                            } ?>
                        </select>
                    </div>
                    
                    <?php if (!empty($data['issued_item_name']) && $role === 1): ?>
                        <div class="grid-row">
                            <span class="label">Issued Quantity:</span>
                            <input type="number" name="issued_qty" class="value" style="color: #28a745; font-weight: bold;"
                                value="<?= htmlspecialchars($data['issued_qty'] ?? 0) ?>" min="0"
                                title="Quantity cannot exceed current stock">
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="pageHeadText" style="margin-bottom: 2%; padding-bottom: 2%;">
                <span class="message-label">Description:</span>
                <div class="form-group">
                    <textarea name="description" class="message-box"
                        rows="6"><?= htmlspecialchars($data['T_description'] ?? '') ?></textarea>
                </div>

                <?php if (isset($role) && $role != 3): ?>
                    <div class="status-section">
                        <div class="status-row">
                            <span class="status-label">Due Date:</span>
                            <input type="datetime-local" name="due_date" class="badge assigned" value="<?= !empty($data['due_date']) ?
                                date('Y-m-d\TH:i', strtotime($data['due_date'])) : '' ?>">
                        </div>
                        <div class="status-row">
                            <span class="status-label">Priority:</span>
                            <select name="priority" class="badge <?= strtolower($data['Priority'] ?? 'unlabeled') ?>"
                                onchange="updateBadgeColor(this)" required>
                                <?php foreach (['Unlabeled', 'Low', 'Medium', 'High'] as $prio): ?>
                                    <option value="<?= htmlspecialchars($prio) ?>" <?= (strtolower($data['Priority'] ?? '') == strtolower($prio)) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($prio) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="status-row">
                            <span class="status-label">Status:</span>
                            <select name="status" class="badge <?= strtolower($data['Status'] ?? 'unresolved') ?>"
                                onchange="updateBadgeColor(this)" required>
                                <?php foreach (['Unresolved', 'Ongoing', 'Resolved'] as $stat): ?>
                                    <option value="<?= $stat ?>" <?= (strtolower($data['Status'] ?? '') == strtolower($stat)) ? 'selected' : '' ?>><?= $stat ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="status-row">
                            <span class="status-label">Assigned to:</span>
                            <select name="staff_id" class="badge <?= empty($data['Assigned_To']) ? 'unassigned' : 'assigned' ?>"
                                onchange="updateBadgeColor(this)">
                                <option value="">UNASSIGNED</option>
                                <?php
                                $allStaff = $q->getAllStaff();
                                foreach ($allStaff as $staff):
                                    ?>
                                    <option value="<?= $staff['U_ID'] ?>" <?= (($data['Assigned_To'] ?? '') == $staff['U_ID']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($staff['FN'] . ' ' . $staff['LN']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="form-footer">
                    <div class="actions" style="margin-top: 5%;">

                        <a href="tileView.php?id=<?= $id ?>&mode=ticketing" class="btn cancel">Cancel <i
                                class="fas fa-x"></i></a>
                        <button type="submit" class="btn download">SAVE CHANGES <i class="fas fa-save"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php endif; ?>