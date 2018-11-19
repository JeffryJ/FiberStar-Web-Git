$(document).ready(function () {
   $(document).on("submit",".form-delete",function () {
       return confirm("Are you sure you want to delete this record?");
   }) ;
});