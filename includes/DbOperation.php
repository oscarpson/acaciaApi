<?php
class DbOperation
{
    private $conn;
    function __construct()
    {
        require_once dirname(__FILE__) . '/DbConnect.php';
        // require __DIR__ . '/../includes/AfricasTalkingGateway.php';
        $db = new DbConnect();
        $this->conn = $db->connect();
    }
    //INSERT INTO `lotInfo` (`lotId`, `itemId`, `quantity`, `lotNo`, `expDate`, `approved`) VALUES (NULL, '1', '10', 'ALN1', '26.3.2020', '0');
    function getAllLots()
    {
        $stmt = $this->conn->prepare("SELECT lotInfo.lotId, lotInfo.itemId, lotInfo.quantity, lotInfo.lotNo, lotInfo.expDate, lotInfo.approved,Test.results FROM lotInfo,Test WHERE lotInfo.itemId =Test.itemId AND lotInfo.approved = '0'");
        $stmt->execute();
        //AccNumber, CurrentReading, MtrReader, MtrStatus,Rdate,Location,ActiveStatus
        $stmt->bind_result($lotId, $itemId, $quantity, $lotNo, $expDate, $approved,$results);

        $lots = array();
        while ($stmt->fetch()) {
            {
                $temp = array();
                $temp["lotId"] = $lotId;
                $temp["itemId"] = $itemId;
                $temp["quantity"] = $quantity;
                $temp["lotNo"] = $lotNo;
                $temp["expDate"] = $expDate;
                $temp["approved"] = $approved;
                $temp["testResults"] = $results;


                array_push($lots, $temp);
            }
        }
        return $lots;
    }
    
      function getAllProducts()
    {
        $stmt = $this->conn->prepare("SELECT itemId,itemName, type, quantity FROM Product where status = '0'");
        $stmt->execute();
        //AccNumber, CurrentReading, MtrReader, MtrStatus,Rdate,Location,ActiveStatus
        $stmt->bind_result($itemId, $itemName, $type, $quantity);

        $product = array();
        while ($stmt->fetch()) {
            {
                $temp = array();
                $temp["itemId"] = $itemId;
                $temp["itemName"] = $itemName;
                $temp["type"] = $type;
                $temp["quantity"] = $quantity;

                array_push($product, $temp);
            }
        }
        return $product;
    }
    
    function getAllDetails()
    {
        $stmt = $this->conn->prepare("SELECT lotInfo.lotId, lotInfo.itemId, lotInfo.quantity, lotInfo.lotNo, lotInfo.expDate, lotInfo.approved,Product.itemName FROM lotInfo,Product WHERE lotInfo.itemId = Product.itemId");
        $stmt->execute();
        //AccNumber, CurrentReading, MtrReader, MtrStatus,Rdate,Location,ActiveStatus
        $stmt->bind_result($lotId, $itemId, $quantity, $lotNo, $expDate, $approved,$itemName);

        $lots = array();
        while ($stmt->fetch()) {
            {
                $temp = array();
                $temp["approved"] = $approved;
                $temp["lotNo"] = $lotNo;
                $temp["expDate"] = $expDate;
                $temp["itemName"] = $itemName;


                array_push($lots, $temp);
            }
        }
        return $lots;
    }
    
    function addProduct($itemName, $itemtype,  $quantity)
    {
        $sth = $this->conn->prepare("INSERT INTO Product ( ItemName, type, quantity) VALUES ( ?,?,?)");
        $sth->bind_param("sss", $itemName, $itemtype, $quantity);

        if ($sth->execute())
            return PRODUCT_CREATED;
        return PRODUCT_CREATION_FAILED;
    }

    function assignLot($itemId, $lotNo,  $quantity,$expDate)
    {
        $approved=0;
       $sth = $this->conn->prepare("INSERT INTO lotInfo ( itemId, quantity, lotNo, expDate, approved) VALUES ( ?,?,?,?,?)");
        $sth->bind_param("sssss", $itemId, $quantity, $lotNo,$expDate,$approved);

        if ($sth->execute())
            return PRODUCT_CREATED;
        return PRODUCT_CREATION_FAILED;
    }

function approveLot($lotNo,$itemId)
    {
        $approved=1;
       $sth = $this->conn->prepare("UPDATE lotInfo SET approved = ? WHERE lotId = ? ");
        $sth->bind_param("si",$approved,$lotNo);
         $sth2 = $this->conn->prepare("UPDATE Product SET status = ? WHERE itemId = ? ");
        $sth2->bind_param("si",$approved,$itemId);
        $sth2->execute();
        if ($sth->execute())
            return PRODUCT_CREATED;
        return PRODUCT_CREATION_FAILED;
    }
    
function addTest($itemId,$desc, $nsamples,  $testtype,$results)
    {
       
       $sth = $this->conn->prepare("INSERT INTO Test (itemId, descs, nsamples, testType, results) VALUES ( ?,?,?,?,?)");
        $sth->bind_param("sssss",$itemId,$desc, $nsamples,  $testtype,$results);

        if ($sth->execute())
            return PRODUCT_CREATED;
        return PRODUCT_CREATION_FAILED;
    }
  
    function addQC($itemId,$weight,$moisture,$storage)
    {
       
       $sth = $this->conn->prepare("INSERT INTO Qcontrol (itemId, weight, moisture, storage) VALUES ( ?,?,?,?)");
        $sth->bind_param("ssss",$itemId,$weight,$moisture,$storage);

        if ($sth->execute())
            return PRODUCT_CREATED;
        return PRODUCT_CREATION_FAILED;
    }
    
 
    function getAllCustomers()
    {
        $stmt = $this->conn->prepare("SELECT EntryId,acc_no,userName,zone,prDate,meter_no,meter_location,Email,Tariff FROM Customers");
        $stmt->execute();
        //AccNumber, CurrentReading, MtrReader, MtrStatus,Rdate,Location,ActiveStatus
        $stmt->bind_result($EntryId, $acc_no, $userName, $zone, $prDate, $meter_no, $meter_location, $Email, $Tariff);

        $readings = array();
        while ($stmt->fetch()) {
            {
                $temp = array();
                //$temp["EntryId"]=$EntryId;
                $temp["acc_no"] = $acc_no;
                $temp["userName"] = $userName;
                $temp["zone"] = $zone;
                $temp["prDate"] = $prDate;
                //$temp["Rdate"]=$Rdate;
                $temp["meter_no"] = $meter_no;
                $temp["meter_location"] = $meter_location;
                //$temp["Email"]=$Email;
                //$temp["Tariff"]=$Tariff;

                array_push($readings, $temp);
            }
        }
        return $readings;
    }
}
