$(document).ready(function(){

    //init some varibles that control the document
    $friend_tab_up = 500;
    $friend_tab_down = 500;
    $friend_tab_delay = 250;

	$(".search, .exist, .confirm").hide();
	$(".exist").show();
	//set the current tab to friends tab
	var $current_tab = ".friends";

	$('.friend_buttons button').click(function(){
		//hide current tab
		if($current_tab === ".friends"){
            $(".exist").slideUp( $friend_tab_up ).delay( $friend_tab_delay );
        }else if($current_tab === ".search"){
            $(".search").slideUp( $friend_tab_up ).delay( $friend_tab_delay );
        }else{
            $(".confirm").slideUp( $friend_tab_up ).delay( $friend_tab_delay );
        }

		//show new tab
		if( $(this).attr("id") === "friends"){
            $(".exist").slideDown( $friend_tab_down );
            $current_tab=".friends";
        }else if( $(this).attr("id") === "search"){
            $(".search").slideDown( $friend_tab_down );
            $current_tab=".search";
        }else{
            $(".confirm").slideDown( $friend_tab_down );
            $current_tab=".confirm";
        }
	});


	$('.search_by #searchbar').keyup(function(){
	   var text = $(this).val();
	   var method = $( ".search_by #method option:selected" ).text();

       var exact_output = "";
       var rough_output = "";
       var exact_count = 0;
       var rough_count = 0;

	   if(method === "Username"){method = usernames;}
	   else if(method === "First Name"){method = firsts;}
	   else{method = lasts;}

	   already_got = [];

	   for(var count=0; count<method.length; count++){
           var check_string = method[count];
           if( check_string.indexOf(text) === 0 ){
			   if(jQuery.inArray(usernames[count],already_got) === -1){
                   var temp = "";
					temp += "<div class='search_box'>";
						temp += "<h3>";
					temp += firsts[count]+" "+lasts[count];
					temp += " ("+usernames[count]+")";
						temp += "</h3>";
					temp += "</div>";

                    if(check_string.length === text.length){
                        rough_output += temp;
                        rough_count += 1;
                    }else{
                        exact_output += temp;
                        exact_count += 1;
                    }

					already_got.push(usernames[count]);
				}
		   }
	   }

       //if($text === ""){$output_string = "";}

       $(".exact_match .matches p").text(exact_count + " matches found")
	   $(".exact_match .matches").html(exact_output);
       $(".rough_match .matches").html(rough_output);
	});
});
