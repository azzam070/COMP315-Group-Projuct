<?php
include "admin_header.php";
include "config.php";

if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    $sql = "UPDATE orders SET status='$status' WHERE id='$order_id'";
    mysqli_query($conn, $sql);
}
?>

<div class="container mt-4">
    <h2>All Orders</h2>
    <table class="table table-bordered mt-4">
        <thead class="table-dark">
            <tr>
                <th>Order ID</th>
                <th>User</th>
                <th>Food</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Status</th>

            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "
SELECT 
    orders.id,
    users.username AS username,
    foods.item_name AS food_name,
    orders.quantity,
    orders.total_price,
    orders.status,
    CONVERT_TZ(orders.created_at, '+00:00', '+03:00') AS created_at_ksa
FROM orders
JOIN users ON orders.user_id = users.id
JOIN foods ON orders.food_id = foods.id
";


            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['username'] ?></td>
                    <td><?= $row['food_name'] ?></td>
                    <td><?= $row['quantity'] ?></td>
                    <td><?= $row['total_price'] ?></td>
                    <td>
                        <form method="POST" class="d-flex">
                            <input type="hidden" name="order_id" value="<?= $row['id'] ?>">
                            <select name="status" class="form-select form-select-sm me-2">
    <option value="pending" <?= $row['status']=='pending' ? 'selected' : '' ?>>Pending</option>
   
    <option value="pick up" <?= $row['status']=='pick up' ? 'selected' : '' ?>>Ready for Pick Up</option>


                            </select>
                            <button type="submit" name="update_status" class="btn btn-primary btn-sm">Save</button>
                        </form>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</div>
