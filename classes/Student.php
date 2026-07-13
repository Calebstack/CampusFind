<?php

require_once "Db.php";

class Student Extends Db{
    private $dbconn;

    public function __construct(){
        $this->dbconn = $this->connect();
        // print_r($this->dbconn);
    }

    public function checkClaim($student_id, $founditems_id){
        try{
            $sql = "SELECT * FROM claims WHERE student_id = ? AND founditems_id = ?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$student_id, $founditems_id]);
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            return $res;
        }catch(PDOException $e){
            return false;
        }
    }

    public function insert_claim($student_id, $founditems_id){
        try{
            $sql = "INSERT INTO claims
            (student_id, founditems_id, claim_date, status)
            VALUES (?, ?, NOW(), 'pending')";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$student_id, $founditems_id]);
            $id =  $this->dbconn->lastInsertId();
            return $id;
        }catch(PDOException $e){
            return $e->getMessage();
        }
    }

    public function getStudentClaims($student_id){
        try{
            $sql = "SELECT claims.*, founditems.founditems_name, founditems.founditems_img, founditems.founditems_location, founditems.founditems_date, categories.category_name 
                    FROM claims 
                    INNER JOIN founditems ON claims.founditems_id = founditems.founditems_id 
                    INNER JOIN categories ON founditems.category_id = categories.categories_id 
                    WHERE claims.student_id = ? 
                    ORDER BY claims.claim_date DESC";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$student_id]);
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }catch(PDOException $e){
            return false;
        }
    }
    
    public function founditems_categrory(){
        try{
            $sql = "SELECT * FROM founditems INNER JOIN categories ON founditems.category_id = categories.categories_id WHERE founditems.status = 'available'";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $res;

        }catch(PDOException $e){
            //echo $e->getMessage();
            return false;
        }
    }

    public function fetch_founditemtid($id){
        try{
            $sql = "SELECT * FROM founditems INNER JOIN categories ON founditems.category_id = categories.categories_id WHERE founditems.founditems_id = ?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$id]);
            $rsp = $stmt->fetch(PDO::FETCH_ASSOC);
            return $rsp;

        }catch(PDOException $e){
        //   return  $e->getMessage();
            return false;
        }
    }
    
    public function get_founditems(){
        try{
            $sql = "SELECT * FROM founditems WHERE status = 'available'";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $res;

        }catch(PDOException $e){
            //echo $e->getMessage();
            return false;
        }
    }
    
    public function report_item($stud_id, $item_name, $item_date, $item_location, $cat_id, $img, $reported_to){
        try{
            $sql = "INSERT INTO founditems(student_id, founditems_name, founditems_date, founditems_location, category_id, founditems_img, reported_to) VALUES(?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$stud_id, $item_name, $item_date, $item_location, $cat_id, $img, $reported_to]);
            $id =  $this->dbconn->lastInsertId();
            return $id;
        }catch(PDOException $e){
            return $e->getMessage();
        }
    }

    public function upload($tmp, $extension){
        try{
            //generate a random file name with dot before extension
            $newname = uniqid(10) . "." . $extension;
            $destination = "../upload/$newname";
            
            move_uploaded_file($tmp, $destination);
            return "../upload/" . $newname;
        }
        catch(Exception $e){
            return false;
        }
    }

    public function get_all_categories(){
        try{
            $sql = "SELECT * FROM categories";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $res;

        }catch(PDOException $e){
            //echo $e->getMessage();
            return false;
        }
    }
    
    public function fetch_profile($id){
        try{
            $sql = "SELECT * FROM students INNER JOIN department ON students.student_dept_id = department.dept_id WHERE student_id = ?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$id]);
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            return $res;

        }catch(PDOException $e){
            //echo $e->getMessage();
            return false;
        }
    }

    public function fetch_studentid($id){
        try{
            $sql = "SELECT * FROM students WHERE student_id = ?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$id]);
            $rsp = $stmt->fetch(PDO::FETCH_ASSOC);
            return $rsp;

        }catch(PDOException $e){
        //   return  $e->getMessage();
          return false;
        }
    }
    
    public function departments(){
        try{
            $sql = "SELECT * FROM department";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $res;

        }catch(PDOExtception $e){
            //echo $e->getMessage();
            return false;
        }
    }
    
    public function logout(){
        unset($_SESSION['useronline']);
        session_destroy();
    }
    
    public function login($email, $pass1){
        try{
            $sql = "SELECT * FROM students WHERE student_email = ?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$email]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            if($data){
                $stored_hash = $data['student_pwd'];
                $chk = password_verify($pass1, $stored_hash);
                if($chk == false){
                    return "Invalid Password";   
                }
                else{
                    return $data['student_id']; 
                }
            }
            else{
                return "Invalid Email";
            }
        }
        catch(PDOException $e){
            //return $e->getMethod();
            return false;
        }
    }
    
    public function check_email($email){
        try{
            $sql = "SELECT * FROM students WHERE student_email = ?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$email]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if($data){
                return "<div class='alert alert-danger'> Email Has Been Used </div>";
            }
            else{
                return "<div class='alert alert-success'> Email Is Available </div>";
            }
        } catch(PDOException $e){
            //return $e->getMessage();
            return false;
        }
    }
        
    public function signup($firstname, $lastname, $email, $pass1, $dept_id){
        $hash = password_hash($pass1, PASSWORD_DEFAULT);
        try{
            $sql = "INSERT INTO students(student_fname, student_lname, student_email, student_pwd, student_dept_id) VALUES(?,?,?,?,?)";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$firstname, $lastname, $email, $hash, $dept_id]);
            $id = $this->dbconn->lastInsertId();
            return $id;
        }catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // public function insert_departments($dept_name){
    //     try{
    //         $sql = "INSERT INTO department(dept_name) VALUES(?)";
    //         $stmt = $this->dbconn->prepare($sql);
    //         $stmt->execute([$dept_name]);
    //         $id = $this->dbconn->lastInsertId();
    //         return $id;
    //     } catch (Exception $e) {
    //         return $e->getMessage();
    //     }
    // }
}

// $stud = new Student;
// $test = $stud->signup("olusegun", "Caleb", "oluseguncaleb6@gmail.com", "54321", "art", 1);
// echo $test;

?>