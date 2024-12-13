<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Windows Explorer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <style>
        body {
            background: linear-gradient(to right, #e0f7fa, #ffffff);
            height: 100vh;
        }

        .folder-structure,
        .subfolder-list {
            padding: 10px;
            overflow-y: auto;
            height: 90vh;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .folder-item {
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        .folder-item:hover {
            transform: scale(1.05);
            background-color: #d1ecf1;
        }

        .folder-item.active {
            background-color: #e2e6ea;
            font-weight: bold;
        }

        .list-group-item i {
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <div class="container-fluid h-100">
        <div class="row h-100">
            <div class="col-4 folder-structure border-end bg-white">
                <h5 class="p-3">Folder Utama</h5>
                <ul id="folder-structure" class="list-group">
                </ul>
            </div>

            <div class="col-8 subfolder-list bg-white">
                <h5 class="p-3 border-bottom">Isi Folder</h5>
                <ul id="subfolder-list" class="list-group">
                </ul>
            </div>
        </div>
    </div>

    <script>
        const baseUrl = '<?= base_url(); ?>';

        async function fetchFolders() {
            const response = await fetch(`${baseUrl}/folders`);
            return await response.json();
        }

        async function fetchSubfolders(parentId) {
            const response = await fetch(`${baseUrl}/subfolders/${parentId}`);
            return await response.json();
        }

        function renderFolders(folders, parentElement, parentId = null) {
            const children = folders.filter(folder => folder.parent_id == parentId);

            children.forEach(folder => {
                const li = document.createElement('li');
                li.innerHTML = `<i class="fas fa-folder text-warning"></i> ${folder.name}`;
                li.classList.add('list-group-item', 'folder-item', 'list-group-item-action', 'rounded');

                li.addEventListener('click', async (e) => {
                    e.stopPropagation();

                    document.querySelectorAll('.folder-item').forEach(item => item.classList.remove('active'));
                    li.classList.add('active');

                    const subfolders = await fetchSubfolders(folder.id);
                    renderSubfolders(subfolders);
                });

                const ul = document.createElement('ul');
                ul.classList.add('list-group', 'ms-3');
                li.appendChild(ul);
                parentElement.appendChild(li);

                renderFolders(folders, ul, folder.id);
            });
        }

        function renderSubfolders(subfolders) {
            const subfolderList = document.getElementById('subfolder-list');
            subfolderList.innerHTML = '';

            subfolders.forEach(subfolder => {
                const li = document.createElement('li');
                li.innerHTML = `<i class="fas fa-file text-secondary"></i> ${subfolder.name}`;
                li.classList.add('list-group-item');
                subfolderList.appendChild(li);
            });
        }

        document.addEventListener('DOMContentLoaded', async () => {
            const folders = await fetchFolders();
            const folderStructure = document.getElementById('folder-structure');
            renderFolders(folders, folderStructure);
        });
    </script>
</body>

</html>