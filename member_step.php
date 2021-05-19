session_start();
//ตรวจดูว่ามี token มาจาก facebook หรือไม่
//ถ้าไม่มีให้กลับไปหน้า index.php
if(!$_SESSION['fb_access_token']){
    header( "location: index.php" );
}else{
    //ตรวจดูว่าเคยลงทะเบียนหรือยัง
    //ถ้ายังไม่มีการลงทะเบียน ให้ลงทะเบียนก่อน
    if(!$user['id'] == query(users.facebook_id)){
        insert $user['id'], $user['name'], $user['email'], $user['picture']['url'] to users table;    
    }

    //ค้นหาข้อมูลขึ้นมาแสดง
    //แสดง ชื่อ, รูปโปรไฟล์, คะแนนรวม
    //มีช่องให้ upload receipt    
    //มีตารางให้ดูข้อมูลการอัพโหลด receipt
    //มีเมนูให้เข้าไปดูหน้าจัดอันดับคะแนนรวม ranking.php
    //มีเมนูให้ออกจากระบบ
}