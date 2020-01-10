function subscribe(userTo, userFrom, button){
    
    if(userTo == userFrom){
        alert("You can't subscribe yourself");
        return;
    }
    
    $.post("ajax/subscribe.php", {userTo: userTo, userFrom: userFrom})
        .done(function(data){
            if(data != null){
                $(button).toggleClass("subscribe unsubscribe");
                var buttonText = $(button).hasClass("subscribe") ? "SUBSCRIBE" : "SUBSCRIBED";

                console.log(data);

                $(button).text(buttonText + " " + data);
            }else{
                alert("Something went wrong");
            }
        })
}