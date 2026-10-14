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

    public function can_claim_item($student_id, $founditems_id){
        try{
            $sql = "SELECT founditems_id FROM founditems
                    WHERE founditems_id = ? AND status = 'available' AND student_id != ?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$founditems_id, $student_id]);
            return (bool)$stmt->fetch(PDO::FETCH_ASSOC);
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
            return false;
        }
    }

    public function get_claim_notification_details($claim_id){
        try{
            $sql = "SELECT claims.claim_id, claims.status, claims.received_at,
                           students.student_fname AS claimant_fname,
                           students.student_email AS claimant_email,
                           reporter.student_fname AS reporter_fname,
                           reporter.student_email AS reporter_email,
                           founditems.founditems_name, founditems.reported_to
                    FROM claims
                    INNER JOIN students ON claims.student_id = students.student_id
                    INNER JOIN founditems ON claims.founditems_id = founditems.founditems_id
                    INNER JOIN students AS reporter ON founditems.student_id = reporter.student_id
                    WHERE claims.claim_id = ?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$claim_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            return false;
        }
    }

    public function get_pending_claim_ids_for_claim($claim_id){
        try{
            $sql = "SELECT other.claim_id
                    FROM claims AS target
                    INNER JOIN claims AS other ON other.founditems_id = target.founditems_id
                    WHERE target.claim_id = ? AND target.status = 'pending'
                      AND other.status = 'pending'";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$claim_id]);
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        }catch(PDOException $e){
            return false;
        }
    }

    public function is_student_allowed($student_id){
        try{
            $stmt = $this->dbconn->prepare("SELECT is_banned FROM students WHERE student_id = ?");
            $stmt->execute([$student_id]);
            $student = $stmt->fetch(PDO::FETCH_ASSOC);
            return $student && empty($student['is_banned']);
        }catch(PDOException $e){
            error_log("CampusFind could not verify student account status: " . $e->getMessage());
            return false;
        }
    }

    public function confirm_claim_received($student_id, $claim_id){
        try{
            $sql = "UPDATE claims
                    SET received_at = NOW()
                    WHERE claim_id = ? AND student_id = ? AND status = 'approved' AND received_at IS NULL";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$claim_id, $student_id]);
            return $stmt->rowCount() === 1;
        }catch(PDOException $e){
            return false;
        }
    }

    public function getStudentClaims($student_id){
        try{
            $sql = "SELECT claims.*, founditems.founditems_name, founditems.founditems_img, founditems.founditems_location, founditems.founditems_date, founditems.reported_to, categories.category_name
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

    public function report_lost_item($student_id, $name, $date, $location, $category_id, $description, $contact){
        try{
            $sql = "INSERT INTO lostitems
                    (student_id, category_id, lostitems_name, lostitems_date, lostitems_location, description, contact)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$student_id, $category_id, $name, $date, $location, $description, $contact]);
            return $this->dbconn->lastInsertId();
        }catch(PDOException $e){
            return false;
        }
    }

    public function get_open_lost_items(){
        try{
            $sql = "SELECT lostitems.*, categories.category_name,
                           students.student_fname, students.student_lname
                    FROM lostitems
                    INNER JOIN categories ON lostitems.category_id = categories.categories_id
                    INNER JOIN students ON lostitems.student_id = students.student_id
                    WHERE lostitems.status = 'open'
                    ORDER BY lostitems.created_at DESC";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            return false;
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

        }catch(PDOException $e){
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
                if(!empty($data['is_banned'])){
                    return "Your account has been suspended. Please contact an administrator.";
                }
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

    public function get_recent_founditems($limit = 6){
        try{
            $sql = "SELECT * FROM founditems WHERE status = 'available' ORDER BY founditems_id DESC LIMIT ?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }catch(PDOException $e){
            return false;
        }
    }

    public function search_founditems($query = "", $category_id = null){
        try{
            $params = [];
            $sql = "SELECT founditems.*, categories.category_name FROM founditems
                    INNER JOIN categories ON founditems.category_id = categories.categories_id
                    WHERE founditems.status = 'available'";
            if(!empty($query)){
                $sql .= " AND (founditems.founditems_name LIKE ? OR founditems.founditems_location LIKE ?)";
                $params[] = "%$query%";
                $params[] = "%$query%";
            }
            if($category_id && $category_id !== "all"){
                $sql .= " AND founditems.category_id = ?";
                $params[] = $category_id;
            }
            $sql .= " ORDER BY founditems.founditems_id DESC";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute($params);
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }catch(PDOException $e){
            return false;
        }
    }

    public function update_profile($student_id, $fname, $lname, $dept_id, $phone = null, $img = null){
        try{
            if($img){
                $sql = "UPDATE students SET student_fname=?, student_lname=?, student_dept_id=?, student_phone=?, student_img=? WHERE student_id=?";
                $stmt = $this->dbconn->prepare($sql);
                $stmt->execute([$fname, $lname, $dept_id, $phone, $img, $student_id]);
            } else {
                $sql = "UPDATE students SET student_fname=?, student_lname=?, student_dept_id=?, student_phone=? WHERE student_id=?";
                $stmt = $this->dbconn->prepare($sql);
                $stmt->execute([$fname, $lname, $dept_id, $phone, $student_id]);
            }
            return true;
        }catch(PDOException $e){
            return $e->getMessage();
        }
    }

    public function upload_profile_pic($tmp, $extension){
        try{
            $newname = "profile_" . uniqid(10) . "." . $extension;
            $destination = "../upload/" . $newname;
            move_uploaded_file($tmp, $destination);
            return "../upload/" . $newname;
        }catch(Exception $e){
            return false;
        }
    }

    public function is_item_reporter($student_id, $founditems_id){
        try{
            $sql = "SELECT student_id FROM founditems WHERE founditems_id = ?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$founditems_id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return ($row && (int)$row["student_id"] === (int)$student_id);
        }catch(PDOException $e){
            return false;
        }
    }

}

// $stud = new Student;

?>
