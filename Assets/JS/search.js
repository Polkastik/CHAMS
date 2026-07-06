// let searchTimer;
// function doGlobalSearch(val) {
//     const dropdown = document.getElementById('searchDropdown');
    
//     if (val.length < 3) {
//         dropdown.style.display = 'none';
//         return;
//     }

//     clearTimeout(searchTimer);
//     searchTimer = setTimeout(() => {
//         fetch(`../Config/globalSearchAction.php?term=${val}`)
//             .then(res => res.text())
//             .then(html => {
//                 dropdown.innerHTML = html;
//                 dropdown.style.display = 'block';
//             });
//     }, 300); 
// }

// function goToResult(type, id) {
//     if (type === 'Ticket') window.location.href = `tileView.php?id=${id}`;
//     if (type === 'Asset') window.location.href = `tileView.php?id=${id}&mode=inventory`;
// }