<?php
class Item
{
    private $prodid;
    private $prodName;
    private $prodDis;
    private $prodImg;
    private $prodPrice;
    private $userName;

    function __construct($prodid, $prodName, $prodDis, $prodImg, $userName)
    {
        $this->prodid = $prodid;
        $this->prodName = $prodName;
        $this->prodDis = $prodDis;
        $this->prodImg = $prodImg;
        $this->userName = $userName;
    }

    function create($connection)
    {
        $sql = "INSERT INTO items (prodName, prodDis, prodImg, userName) VALUES (?, ?, ?, ?)";
        $statement = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($statement, "ssss", $this->prodName, $this->prodDis, $this->prodImg, $this->userName);

        if (!mysqli_stmt_execute($statement)) {
            echo '<script>alert("Failed to create item.");</script>';
            return;
        }
    }

    function sqlExecutor($connection, $sql)
    {
        $result1 = mysqli_query($connection, $sql);
        if (mysqli_num_rows($result1) > 0) {
            return $result1;
        } else {
            return null;
        }
    }

    function update($connection, $prodPrice)
    {
        $sql = "UPDATE items SET prodName = '$this->prodName', prodDis = '$this->prodDis', prodPrice = '$prodPrice', prodImg = '$this->prodImg' , status = 'Pending' WHERE prodId = '$this->prodid' AND userName = '$this->userName'";
        if (mysqli_query($connection, $sql)) {
            $successMessage = "Product updated successfully.";
        } else {
            echo "Error updating product: " . mysqli_error($connection);
        }

        return $successMessage;
    }

    function delete($connection)
    {
        $sql = "DELETE FROM items WHERE prodId = ? AND userName = ?";
        if ($stmt = $connection->prepare($sql)) {
            $stmt->bind_param('is', $this->prodid, $this->userName);

            if ($stmt->execute()) {
                echo "<script>window.location.href='delete-prod.php?projectdeletestatus=success';</script>";
            } else {
                echo "<script>window.location.href='delete-prod.php?projectdeletestatus=error';</script>";
            }
            $stmt->close();
        } else {
            echo "<script>window.location.href='delete-prod.php?projectdeletestatus=error';</script>";
        }
    }
}