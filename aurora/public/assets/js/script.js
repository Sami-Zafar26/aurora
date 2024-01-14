var reupload_list=document.getElementsByClassName("reupload-list");

Array.from(reupload_list).forEach(function (element) {
    element.addEventListener("click",function (e) {
        table=e.target.parentNode.parentNode.parentNode;
        
        listName=table.getElementsByClassName("list_name")[0].innerText;
        listDescription=table.getElementsByClassName("list_description")[0].innerText;

        if (listDescription=="--") {
            listDescription="";
        }
        serialnumber=e.target.id;

        listname.value=listName;
        listdescription.value=listDescription;
        token.value=serialnumber;

        $('#reupload-list-modal').modal('toggle')
    }); 
});