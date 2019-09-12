document.getElementById('add_user').addEventListener("click", function(event){
    location.href= "add_user.php?mode=add";
});

function removeUser(ID, K){
   let confirmThis = confirm("Are you sure, you want to delete this user?");
   if(confirmThis) {
       location.href = "add_user.php?mode=delete&ID="+ID+"&K="+K;
       // console.log("add_user.php?mode=delete&ID="+ID);}}
   }
   else
   {
       location.href="manage_user.php";
   }


}
function editUser(ID, K){
    location.href= "add_user.php?mode=edit&ID="+ID+"&K="+K;
    // console.log("add_user.php?mode=delete&ID="+ID);
}