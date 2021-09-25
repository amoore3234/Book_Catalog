<?php

/*
 * @author moore
 */
class ThirdData extends Database {
    
    public function getThirdInfo() {
        if(isset($_GET['order'])) {
            $order = $_GET['order'];
        } else {
            $order = 'price';
        }
        
        if(isset($_GET['sort'])) {
            $sort = $_GET['sort'];
        } else {
            $sort = 'ASC';
        }
        
        $query = "SELECT * FROM book ORDER BY ".$order." ".$sort." LIMIT 6 OFFSET 12";
        $courses = $this->connect()->query($query);
   
        if($sort == 'DESC') {
            $sort = 'ASC';
        } else {
            $sort = 'DESC';
        }
        
        echo "<table style='width: 1200px; margin: auto; backgroud-color: black;'>"
                . "<tr style='background-color:#cdf7dd;'>"
                    . "<th>Course #</th>"
                    . "<th>Course Title</th>"
                    . "<th>Book Image</th>"
                    . "<th>Book Title</th>"
                    . "<th><a href='?order=price&&sort=$sort'>Price</a></th>"
                . "</tr>";
       
        foreach($courses as $course) {
            
            $isbn = $course['isbn13'];
            $courseID = $this->getCourseID($course);
            $courseTitle = $this->getCourseTitle($course);
            $image = $this->getImage($course);
            $bookTitle = $course['bookTitle'];
            $price = "$".$course['price'];
            $credit = $this->getCredit($course);
            
            echo "<tr style='text-align: center;'><td>{$courseID}</td>
                      <td>{$courseTitle} ({$credit})</td>
                      <td><a href='detail_page.php?id={$isbn}'>{$image}</a></td>
                      <td>{$bookTitle}</td>
                      <td>{$price}</td></tr>";
        }
        echo "</table>";
        
        echo "<div style='text-align: center; font-weight: bold; font-size: 30px;'>
                    <span><a href='index.php'>1</a></span> 
                    <span><a href='second_page.php'>2</a></span> 
                    <span><a href='third_page.php'>3</a></span>
              </div>";
    }
    
    public function getCourseID($course) {
        $query = 'SELECT * FROM coursebook, course';
        $courseIDs = $this->connect()->query($query);
        
        foreach($courseIDs as $courseID) {
            if ($course['isbn13'] == $courseID['book'] && $courseID['course'] == $courseID['courseID']) {
            return $courseID['courseID'];
            }
        }
    }
    
    public function getCourseTitle($course) {
        $query = 'SELECT * FROM course, coursebook';
        $courseTitles = $this->connect()->query($query);
        
        foreach($courseTitles as $courseTitle) {
            if ($course['isbn13'] == $courseTitle['book'] && $courseTitle['course'] == $courseTitle['courseID']) {
            return $courseTitle['courseTitle'];
            }
        }
    }
    
    public function getImage($course) {
       
            
            return '<img src="images/'.$course['isbn13'].'.jpg" />';
             
    }
    
    public function getCredit($course) {
        $query = 'SELECT * FROM course, coursebook';
        $credits = $this->connect()->query($query);
        
        foreach($credits as $credit) {
            if ($course['isbn13'] == $credit['book'] && $credit['course'] == $credit['courseID']) {
            return $credit['credit'];
            }
        }
    }
    
}