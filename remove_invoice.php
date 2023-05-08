<?php
include "dbconnection.php";
$dbcon = createDbConnection();

$invoice_item_id = 10;

try {

    $command = "DELETE FROM invoice_items WHERE InvoiceLineId = :invoice_item_id";
    $statement = $dbcon->prepare($command);
    $statement->bindParam(":invoice_item_id", $invoice_item_id);
    $statement->execute();

} catch (PDOException $e) {
    $e->getMessage();
}
