<?php
class Desk {
    private $conn;
    public function __construct($conn) { $this->conn = $conn; }
    public function createDesk($Name, $Description, $Price, $ImageURL, $Dimensions, $OtherInfo) {
        $stmt = $this->conn->prepare("INSERT INTO Desks (Name, Description, Price, ImageURL, Dimensions, OtherInfo) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdsss", $Name, $Description, $Price, $ImageURL, $Dimensions, $OtherInfo);
        $stmt->execute();
        if ($stmt->error) {return false;}
        return $stmt->insert_id;  
    }
     public function getDesksWithFilters($minPrice, $maxPrice, $deskName) {
        $query = "SELECT * FROM Desks WHERE 1";
        if ($minPrice !== null) {
            $query .= " AND Price >= " . (float) $minPrice;
        }
        if ($maxPrice !== null) {
            $query .= " AND Price <= " . (float) $maxPrice;
        }
        if ($deskName !== null) {
            $query .= " AND Name LIKE ?";
        }
        $stmt = $this->conn->prepare($query);
        if ($deskName !== null) {
            $nameParam = '%' . $deskName . '%';
            $stmt->bind_param("s", $nameParam);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $Desks = array();
        while ($row = $result->fetch_assoc()) {
            $Desks[] = $row;
        }
        $result->free_result();
        return $Desks;
    }

    public function getDesks() {
        $result = $this->conn->query("SELECT * FROM Desks");
        if (!$result) {
            return false;
        }
        $Desks = array();
        while ($row = $result->fetch_assoc()) {
            $Desks[] = $row;
        }
        $result->free_result();
        return $Desks;
    }

    public function getDeskByID($DeskID) {
        $stmt = $this->conn->prepare("SELECT * FROM Desks WHERE DeskID=?");
        $stmt->bind_param("i", $DeskID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $desk = $result->fetch_assoc();
            $result->free_result();
            return $desk;
        } else {return false;}
    }
    public function updateDesk($DeskID, $Name, $Description, $Price, $ImageURL, $Dimensions, $OtherInfo)
    {
        $query = "UPDATE desks SET Name=?, Description=?, Price=?, ImageURL=?, Dimensions=?, Otherinfo=? WHERE DeskID=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssdsssi", $Name, $Description, $Price, $ImageURL, $Dimensions, $OtherInfo, $DeskID);
        return $stmt->execute();
    }
    public function deleteDesk($DeskID) {
        $stmt = $this->conn->prepare("DELETE FROM Desks WHERE DeskID = ?");
        $stmt->bind_param("i", $DeskID);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true; 
        } else {
            return false;
        }
    }
}
?>
