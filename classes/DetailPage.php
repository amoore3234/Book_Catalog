<?php

/**
 * Description of DetailPage
 *
 * @author moore
 */
class DetailPage extends Database{
    public function getDetails() {
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            
            $query = "SELECT * FROM book WHERE isbn13 ='$id'";
            $details = $this->connect()->query($query);
            
            echo "<table style='width: 1200px; margin: auto;'>";
            
            foreach($details as $detailPage) {
                
                $image = $this->getImage($detailPage);
                $courseID = $this->getCourseID($detailPage);
                $courseTitle = $this->getCourseTitle($detailPage);
                $bookTitle = $detailPage['bookTitle'];
                $price = "$".$detailPage['price'];
                $names = $this->getNames($detailPage);
                $publisher = $this->getPublisher($detailPage);
                $edition = $detailPage['edition'];
                $dateFormat = $this->formatDate($detailPage);
                $numPages = $detailPage['length'];
                $description = $detailPage['description'];
                $credit = $this->getCredit($detailPage);
                
                echo "<tr><td> $image</td>
                          <td> For course: {$courseID} {$courseTitle} ({$credit})<br>
                               Book Title: {$bookTitle} <br>
                               Price: {$price}<br>
                               Authors: {$names}<br>
                               Publisher: {$publisher}<br>
                               Edition: {$edition} edition {$dateFormat}<br>
                               Length: {$numPages} pages<br>
                               ISBN-13: {$id}</td></tr>
                      <tr><td colspan='2'>{$description}</td></tr>";
            }
            
            echo "</table>";
         
        }
       
    }
    
    public function getCourseID($detailPage) {
        $query = 'SELECT * FROM coursebook, course';
        $courseIDs = $this->connect()->query($query);
        
        foreach($courseIDs as $courseID) {
            if ($detailPage['isbn13'] == $courseID['book'] && $courseID['course'] == $courseID['courseID']) {
            return $courseID['courseID'];
            }
        }
    }
    
    public function getImage($detailPage) {
        
            
            return '<img src="images/'.$detailPage['isbn13'].'.jpg" />';
             
    }
    
    public function getCourseTitle($detailPage) {
        $query = 'SELECT * FROM course, coursebook';
        $courseTitles = $this->connect()->query($query);
        
        foreach($courseTitles as $courseTitle) {
            if ($detailPage['isbn13'] == $courseTitle['book'] && $courseTitle['course'] == $courseTitle['courseID']) {
            return $courseTitle['courseTitle'];
            }
        }
    }
    
    public function getPrice($detailPage) {
        
        $query = 'SELECT * FROM coursebook, course, book';
        $prices = $this->connect()->query($query);
        
        foreach($prices as $price) {
            if ($detailPage['courseID'] == $price['course'] && $price['book'] == $price['isbn13']) {
            return $price['price'];
            }
        }
    }
    
    public function getNames($detailPage) {
        $query = 'SELECT * FROM author, authorbook';
        $names = $this->connect()->query($query);
        $result = [];
        
        foreach($names as $name) {
            if ($detailPage['isbn13'] == $name['book'] && $name['author'] == $name['authorID']) {
                $fullName = $name['firstName']. " ".$name['lastName'];
                 array_push($result, $fullName);
            }
        }
        return implode(", ", $result);
    }
    
    public function getPublisher($detailPage) {
        
        $query = 'SELECT * FROM publisher';
        $publishers = $this->connect()->query($query);
        
        foreach($publishers as $publisher) {
            if ($detailPage['publisher'] == $publisher['publisherID']) {
            return $publisher['publisher'];
            }
        }
    }
    
    public function formatDate($detailPage) {
        
        $date = date_create($detailPage['publishDate']);
        return date_format($date, "Y/m/d");
    }
    
    public function getCredit($detailPage) {
        $query = 'SELECT * FROM course, coursebook';
        $credits = $this->connect()->query($query);
        
        foreach($credits as $credit) {
            if ($detailPage['isbn13'] == $credit['book'] && $credit['course'] == $credit['courseID']) {
            return $credit['credit'];
            }
        }
    }
    
}
