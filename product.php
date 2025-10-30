<?php
include("config.php");
$result = mysqli_query($koneksi, "SELECT * FROM products");
?>
<h2>Daftar Produk</h2>
<a href="add_product.php">Tambah Produk</a>
<table border="1">
  <tr><th>Nama</th><th>Stok</th><th>Harga</th><th>Aksi</th></tr>
  <?php while($row = mysqli_fetch_assoc($result)) { ?>
  <tr>
    <td><?= $row['name'] ?></td>
    <td><?= $row['stock'] ?></td>
    <td><?= $row['price'] ?></td>
    <td><a href="edit_product.php?id=<?= $row['id'] ?>">Edit</a> | 
        <a href="delete_product.php?id=<?= $row['id'] ?>">Hapus</a></td>
  </tr>
  <?php } ?>
</table>
