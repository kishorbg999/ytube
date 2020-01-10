$(document).ready(function(){
    
    $(".navShowHide").on("click", function(){
        let main = $("#mainSectionContainer");
        let nav = $("#sideNavContainer");

        if(main.hasClass("leftPadding")) {
            nav.hide();
        }else{
            nav.show();
        }

        main.toggleClass("leftPadding");
    })

});

function notSignedIn(){
    alert("You must sign in to the operation");
}

// document.querySelector(".navShowHide").addEventListener("click", function(){
//     console.log("clicked");
// });