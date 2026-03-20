function fetchSubCategories(categoryId) {
    const subGroup = document.getElementById('subCategoryGroup');
    const subSelect = document.getElementById('sub_type');

    if (!categoryId) {
        subGroup.style.display = 'none';
        return;
    }

    fetch(`../Config/subCategories.php?cat_id=${categoryId}`)
        .then(response => response.json())
        .then(data => {
            subSelect.innerHTML = '<option value="">Select a sub-category</option>';
            
            if (data.length > 0) {
                data.forEach(sub => {
                    let option = document.createElement('option');
                    option.value = sub.sub_id;
                    option.textContent = sub.sub_name;
                    subSelect.appendChild(option);
                });
                subGroup.style.display = 'block';
            } else {
                subGroup.style.display = 'none';
            }
        })
        .catch(err => console.error('Error fetching subcategories:', err));
}