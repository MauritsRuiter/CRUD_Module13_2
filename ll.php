<a href="edit.php?edit=<?php echo $row["id"]; ?>" class="btn btn-sm btn-outline-success" style="text-decoration: none !important; border-radius: 0;">Bewerken</a>
<a href="index.php?delete=<?php echo $row["id"]; ?>" class="btn btn-sm btn-outline-danger" style="text-decoration: none !important; border-radius: 0;" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal<?php echo $row["id"]; ?>">Verwijderen</a>