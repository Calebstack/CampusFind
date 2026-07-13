<?php

require_once "Db.php";

class Admin extends Db{

    private $dbconn;

    public function __construct(){
        $this->dbconn = $this->connect();
        // print_r($this->dbconn);
    }

    public function count_founditems(){
        try{
            $sql = "SELECT * FROM founditems";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $res;

        }catch(PDOExtception $e){
            //echo $e->getMessage();
            return false;
        }
    }

    public function count_users(){
        try{
            $sql = "SELECT * FROM students";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $res;

        }catch(PDOExtception $e){
            //echo $e->getMessage();
            return false;
        }
    }

    public function count_pending_claims(){
        try{
            $sql = "SELECT * FROM claims WHERE status = 'pending'";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $res;

        }catch(PDOException $e){
            //echo $e->getMessage();
            return false;
        }
    }

    public function count_approved_claims(){
        try{
            $sql = "SELECT * FROM claims WHERE status = 'approved'";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $res;

        }catch(PDOException $e){
            //echo $e->getMessage();
            return false;
        }
    }

    public function founditems_categrory(){
        try{
            $sql = "SELECT * FROM founditems INNER JOIN categories ON founditems.category_id = categories.categories_id";
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

    public function delete_item($id){
        try{
            $sql = "DELETE FROM founditems WHERE founditems_id = ?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$id]);
            return true;

        }catch(PDOException $e){
            //   return  $e->getMessage();
            return false;
        }
    }

    public function get_all_students(){
        try{
            $sql = "SELECT students.*, department.dept_name 
                    FROM students 
                    INNER JOIN department ON students.student_dept_id = department.dept_id";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $res;

        }catch(PDOException $e){
            //echo $e->getMessage();
            return false;
        }
    }

    public function count_items_reported($student_id){
        try{
            $sql = "SELECT COUNT(*) as count FROM founditems WHERE student_id = ?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$student_id]);
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            return $res['count'] ?? 0;

        }catch(PDOException $e){
            return 0;
        }
    }

    public function count_claims_made($student_id){
        try{
            $sql = "SELECT COUNT(*) as count FROM claims WHERE student_id = ?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$student_id]);
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            return $res['count'] ?? 0;

        }catch(PDOException $e){
            return 0;
        }
    }

    public function get_all_claims(){
        try{
            $sql = "SELECT claims.*, 
                           students.student_fname, students.student_lname, students.student_email,
                           founditems.founditems_name, founditems.founditems_img
                    FROM claims 
                    INNER JOIN students ON claims.student_id = students.student_id 
                    INNER JOIN founditems ON claims.founditems_id = founditems.founditems_id 
                    ORDER BY claims.claim_date DESC";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $res;

        }catch(PDOException $e){
            return false;
        }
    }
    
    public function fetch_adminid($id){
        try{
            $sql = "SELECT * FROM admin WHERE admin_id = ?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$id]);
            $rsp = $stmt->fetch(PDO::FETCH_ASSOC);
            return $rsp;

        }catch(PDOException $e){
        //   return  $e->getMessage();
          return false;
        }
    }

    public function approve_claim($claim_id, $admin_id){
        try {
            $this->dbconn->beginTransaction();

            // 1. Get the founditems_id associated with this claim
            $sql_get = "SELECT founditems_id FROM claims WHERE claim_id = ?";
            $stmt_get = $this->dbconn->prepare($sql_get);
            $stmt_get->execute([$claim_id]);
            $claim = $stmt_get->fetch(PDO::FETCH_ASSOC);

            if (!$claim) {
                $this->dbconn->rollBack();
                return false;
            }

            $founditems_id = $claim['founditems_id'];

            // 2. Approve this claim
            $sql_approve = "UPDATE claims SET status = 'approved', admin_id = ? WHERE claim_id = ?";
            $stmt_approve = $this->dbconn->prepare($sql_approve);
            $stmt_approve->execute([$admin_id, $claim_id]);

            // 3. Mark the found item as claimed
            $sql_item = "UPDATE founditems SET status = 'claimed' WHERE founditems_id = ?";
            $stmt_item = $this->dbconn->prepare($sql_item);
            $stmt_item->execute([$founditems_id]);

            // 4. Reject other pending claims for this same item
            $sql_reject_others = "UPDATE claims SET status = 'rejected', admin_id = ? WHERE founditems_id = ? AND claim_id != ? AND status = 'pending'";
            $stmt_reject_others = $this->dbconn->prepare($sql_reject_others);
            $stmt_reject_others->execute([$admin_id, $founditems_id, $claim_id]);

            $this->dbconn->commit();
            return true;
        } catch (PDOException $e) {
            $this->dbconn->rollBack();
            return false;
        }
    }

    public function reject_claim($claim_id, $admin_id){
        try {
            $sql = "UPDATE claims SET status = 'rejected', admin_id = ? WHERE claim_id = ?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$admin_id, $claim_id]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function logout(){
        unset($_SESSION['adminonline']);
        session_destroy();
    }
    
    public function login($email, $pass1){
        try{
            $sql = "SELECT * FROM admin WHERE admin_email = ?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$email]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            if($data){
                $stored_hash = $data['admin_pwd'];
                $chk = password_verify($pass1, $stored_hash);
                if($chk == false){
                    return "Invalid Password";   
                }
                else{
                    return $data['admin_id']; 
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

    // public function signup($fullname, $email, $pass1){
    //     $hash = password_hash($pass1, PASSWORD_DEFAULT);
    //     try{
    //         $sql = "INSERT INTO admin(admin_fullname, admin_email, admin_pwd) VALUES(?,?,?)";
    //         $stmt = $this->dbconn->prepare($sql);
    //         $stmt->execute([$fullname, $email, $hash]);
    //         $id = $this->dbconn->lastInsertId();
    //         return $id;
    //     }catch(Exception $e) {
    //         return $e->getMessage();
    //     }
    // }
}

// $admin = new Admin;
// $admins = $admin->signup('Olusegun Caleb', 'oluseguncaleb6@gmail.com', '1234');
// echo $admins;


?>