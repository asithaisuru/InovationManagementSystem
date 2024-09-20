<?php
class Item
{
    private $prodid;
    private $prodName;
    private $prodDis;
    private $prodImg;
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

    function read($connection)
    {
        $sql = "SELECT * FROM items";
        $result = mysqli_query($connection, $sql);
        return $result;
    }

    function update($connection)
    {
        $sql = "UPDATE items SET prodName = ?, prodDis = ?, prodImg = ? WHERE prodid = ?";
        $statement = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($statement, "sssi", $this->prodName, $this->prodDis, $this->prodImg, $this->prodid);

        if (!mysqli_stmt_execute($statement)) {
            echo '<script>alert("Failed to update item.");</script>';
            return;
        }
    }

    function delete($connection)
    {
        $sql = "DELETE FROM items WHERE prodid = ?";
        $statement = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($statement, "i", $this->prodid);

        if (!mysqli_stmt_execute($statement)) {
            echo '<script>alert("Failed to delete item.");</script>';
            return;
        }
    }
}