<style>

/* The actual timeline (the vertical ruler) */
.timeline {
  
  margin: 0 auto;
}

/* The actual timeline (the vertical ruler) */
.timeline::after {
  content: '';
  position: absolute;
  width: 6px;
  background-color: white;
  top: 0;
  bottom: 0;
  left: 3%;
    margin-left: 2px;
}

/* Container around content */
#timeline .container {
    padding: 10px 45px;
  position: relative;
  background-color: inherit;
  width: 87.6%;
}

/* The circles on the timeline */
#timeline .container::after {
  content: '';
  position: absolute;
  width: 15px;
  height: 15px;
  right: -17px;
  background-color: white;
  border: 4px solid #25AAe1;
  top: 20px;
  border-radius: 50%;
  z-index: 1;
}

/* Place the container to the left */
#timeline .left {
  left: 0;
}

/* Place the container to the right */
/* #timeline .right {
  left: 50%;
} */

/* Add arrows to the left container (pointing right) */
#timeline .left::before {
  content: " ";
  height: 0;
  position: absolute;
  top: 22px;
  width: 0;
  z-index: 1;
  right: 30px;
  border: medium solid white;
  border-width: 10px 0 10px 10px;
  border-color: transparent transparent transparent white;
}

/* Add arrows to the right container (pointing left) */
#timeline .right::before {
  content: " ";
  height: 0;
  position: absolute;
  top: 22px;
  width: 0;
  z-index: 1;
  left: 35px;
  border: medium solid white;
  border-width: 10px 10px 10px 0;
  border-color: transparent white transparent transparent;
}

/* Fix the circle for containers on the right side */
#timeline .right::after {
    left: 8px;
}

/* The actual content */
#timeline .content {
  padding: 20px 30px;
  background-color: white;
  position: relative;
  border-radius: 6px;
  -moz-box-shadow: 1px 2px 4px rgba(0, 0, 0,0.5);
  -webkit-box-shadow: 1px 2px 4px rgba(0, 0, 0, .5);
  box-shadow: 1px 2px 4px rgba(0, 0, 0, .5);
}

/* Media queries - Responsive timeline on screens less than 600px wide */
@media screen and (max-width: 600px) {
  /* Place the timelime to the left */
  .timeline::after {
  left: 31px;
  }
  
  /* Full-width containers */
  #timeline .container {
  width: 100%;
  padding-left: 70px;
  padding-right: 25px;
  }
  
  /* Make sure that all arrows are pointing leftwards */
  #timeline .container::before {
  left: 60px;
  border: medium solid white;
  border-width: 10px 10px 10px 0;
  border-color: transparent white transparent transparent;
  }

  /* Make sure all circles are at the same spot */
  #timeline .left::after, #timeline>.right::after {
  left: 15px;
  }
  
  /* Make all right containers behave like the left ones */
  #timeline .right {
  left: 0%;
  }

  
}
.checkbox-inline, .radio-inline {
    position: relative;
    display: inline-block;
    padding-left: 0px;
    margin-bottom: 5px;
    font-weight: 400;
    vertical-align: middle;
    cursor: pointer;
    width: 12.5%;
}
#newProposalColumnFilters {
    position: absolute;
    top: 40px;
    right: 0;
    background-color: #ebedea;
    width: 200px;
    -webkit-box-shadow: 10px 10px 5px 0px rgba(0, 0, 0, 0.75);
    -moz-box-shadow: 10px 10px 5px 0px rgba(0, 0, 0, 0.75);
    box-shadow: 10px 10px 5px 0px rgba(0, 0, 0, 0.75);
    padding: 0 5px 10px 5px;
    z-index: 100;
    display: none;
    border-radius: 5px;
    margin-top: 1px;
}
</style>

<p><span style="font-size: 16px;font-weight:bold"><i class="fa fa-fw fa-history"></i> Proposal Events</span>
<a class="m-btn grey tiptip" style="margin-left: 525px;border-radius: 2px;display: inline-block;line-height: 30px;padding: 0 1rem;/* vertical-align: ;; none; */color: #fff;background-color: #25aae1;letter-spacing: .5px;cursor: pointer;" title="Events Filters" id="eventFilterButton"><i
                    class="fa fa-fw fa-table"></i> Events Filters</a>
</p>

                    <div id="newProposalColumnFilters">

<p style="padding: 5px;"> <a href="javascript:void(0);" id="selectAll">All</a> / <a href="javascript:void(0);" id="selectNone">None</a></p>

<div class="clearfix"></div>

<div class="filterRow" style="margin-top:2px;display: inline-grid;">
<?php
foreach($proposal_event_types as $type){
?>

<label class="checkbox-inline">
    <input type="checkbox" checked="checked" class="column_show" name="column_show" value="<?=$type->id;?>"><span style="margin-top: 3px;position: absolute;width:200px"><?=$type->getTypeName();?></span>
</label>
<?php 

}
?>


</div>

<div class="clearfix filterRow"></div>



</div>


<hr />
<div id="timeline_box" style="position:absolute;width: 825px;height: 540px;overflow: scroll;">

    <div class="timeline" id="timeline">
        <?php
            if(count($proposal_events)<1){
              echo '<h4 style="text-align:center">No Events</h4>';
            }
            $month = '';
            $year= '';
            foreach($proposal_events as $event){
              $time=strtotime($event->created_at);
              if($month == date("F",$time) && $year == date("Y",$time)){
                
              }else{
                echo '<p style="font-size:14px;padding-left: 60px;font-weight: bold;"><i class="fa fa-fw fa-calendar"></i> '.date("F",$time).' '.date("Y",$time).'</p>';
                $month=date("F",$time);
                $year=date("Y",$time);
              }
              

?>
        
            <div class="container right " >
                <div class="content" style="padding-left: 5px;">
                <span style="float: left;margin-top: 20px;min-height: 50px;padding-right: 5px;"><i class="fa fa-2x fa-fw <?=$event->type_icon;?>"></i></span>
                <p><span style="font-size:13px;font-weight:bold;"><?= date_format(date_create($event->created_at),"M d, Y g:ia");?></span><span style="font-size:13px;font-weight:bold;float:right"><i class="fa fa-fw fa-user"></i> <?=($event->fullName)?:$event->user_name;?></span></p>
                <p style="    margin-top: 10px;"><?=$event->event_text;?>.</p>
                </div>
            </div>
        <?php } ?>
        
        
    </div>
</div>
<script >
var DateFormat={};!function(e){var I=["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],O=["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],v=["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],w=["January","February","March","April","May","June","July","August","September","October","November","December"],a={Jan:"01",Feb:"02",Mar:"03",Apr:"04",May:"05",Jun:"06",Jul:"07",Aug:"08",Sep:"09",Oct:"10",Nov:"11",Dec:"12"},u=/\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}\.?\d{0,3}[Z\-+]?(\d{2}:?\d{2})?/;DateFormat.format=function(){function o(e){return a[e]||e}function i(e){var a,r,t,n,s,o=e,i="";return-1!==o.indexOf(".")&&(o=(n=o.split("."))[0],i=n[n.length-1]),3<=(s=o.split(":")).length?(a=s[0],r=s[1],t=s[2].replace(/\s.+/,"").replace(/[a-z]/gi,""),{time:o=o.replace(/\s.+/,"").replace(/[a-z]/gi,""),hour:a,minute:r,second:t,millis:i}):{time:"",hour:"",minute:"",second:"",millis:""}}function D(e,a){for(var r=a-String(e).length,t=0;t<r;t++)e="0"+e;return e}return{parseDate:function(e){var a,r,t={date:null,year:null,month:null,dayOfMonth:null,dayOfWeek:null,time:null};if("number"==typeof e)return this.parseDate(new Date(e));if("function"==typeof e.getFullYear)t.year=String(e.getFullYear()),t.month=String(e.getMonth()+1),t.dayOfMonth=String(e.getDate()),t.time=i(e.toTimeString()+"."+e.getMilliseconds());else if(-1!=e.search(u))a=e.split(/[T\+-]/),t.year=a[0],t.month=a[1],t.dayOfMonth=a[2],t.time=i(a[3].split(".")[0]);else switch(6===(a=e.split(" ")).length&&isNaN(a[5])&&(a[a.length]="()"),a.length){case 6:t.year=a[5],t.month=o(a[1]),t.dayOfMonth=a[2],t.time=i(a[3]);break;case 2:r=a[0].split("-"),t.year=r[0],t.month=r[1],t.dayOfMonth=r[2],t.time=i(a[1]);break;case 7:case 9:case 10:t.year=a[3];var n=parseInt(a[1]),s=parseInt(a[2]);n&&!s?(t.month=o(a[2]),t.dayOfMonth=a[1]):(t.month=o(a[1]),t.dayOfMonth=a[2]),t.time=i(a[4]);break;case 1:r=a[0].split(""),t.year=r[0]+r[1]+r[2]+r[3],t.month=r[5]+r[6],t.dayOfMonth=r[8]+r[9],t.time=i(r[13]+r[14]+r[15]+r[16]+r[17]+r[18]+r[19]+r[20]);break;default:return null}return t.time?t.date=new Date(t.year,t.month-1,t.dayOfMonth,t.time.hour,t.time.minute,t.time.second,t.time.millis):t.date=new Date(t.year,t.month-1,t.dayOfMonth),t.dayOfWeek=String(t.date.getDay()),t},date:function(a,e){try{var r=this.parseDate(a);if(null===r)return a;for(var t,n=r.year,s=r.month,o=r.dayOfMonth,i=r.dayOfWeek,u=r.time,c="",h="",l="",m=!1,y=0;y<e.length;y++){var d=e.charAt(y),f=e.charAt(y+1);if(m)"'"==d?(h+=""===c?"'":c,c="",m=!1):c+=d;else switch(l="",c+=d){case"ddd":h+=(S=i,I[parseInt(S,10)]||S),c="";break;case"dd":if("d"===f)break;h+=D(o,2),c="";break;case"d":if("d"===f)break;h+=parseInt(o,10),c="";break;case"D":h+=o=1==o||21==o||31==o?parseInt(o,10)+"st":2==o||22==o?parseInt(o,10)+"nd":3==o||23==o?parseInt(o,10)+"rd":parseInt(o,10)+"th",c="";break;case"MMMM":h+=(M=s,void 0,g=parseInt(M,10)-1,w[g]||M),c="";break;case"MMM":if("M"===f)break;h+=(k=s,void 0,p=parseInt(k,10)-1,v[p]||k),c="";break;case"MM":if("M"===f)break;h+=D(s,2),c="";break;case"M":if("M"===f)break;h+=parseInt(s,10),c="";break;case"y":case"yyy":if("y"===f)break;h+=c,c="";break;case"yy":if("y"===f)break;h+=String(n).slice(-2),c="";break;case"yyyy":h+=n,c="";break;case"HH":h+=D(u.hour,2),c="";break;case"H":if("H"===f)break;h+=parseInt(u.hour,10),c="";break;case"hh":h+=D(t=0===parseInt(u.hour,10)?12:u.hour<13?u.hour:u.hour-12,2),c="";break;case"h":if("h"===f)break;t=0===parseInt(u.hour,10)?12:u.hour<13?u.hour:u.hour-12,h+=parseInt(t,10),c="";break;case"mm":h+=D(u.minute,2),c="";break;case"m":if("m"===f)break;h+=parseInt(u.minute,10),c="";break;case"ss":h+=D(u.second.substring(0,2),2),c="";break;case"s":if("s"===f)break;h+=parseInt(u.second,10),c="";break;case"S":case"SS":if("S"===f)break;h+=c,c="";break;case"SSS":h+=D(u.millis.substring(0,3),3),c="";break;case"a":h+=12<=u.hour?"PM":"AM",c="";break;case"p":h+=12<=u.hour?"pm":"am",c="";break;case"E":h+=(b=i,O[parseInt(b,10)]||b),c="";break;case"'":c="",m=!0;break;default:h+=d,c=""}}return h+=l}catch(e){return console&&console.log&&console.log(e),a}var b,k,p,M,g,S},prettyDate:function(e){var a,r,t,n,s;if("string"!=typeof e&&"number"!=typeof e||(a=new Date(e)),"object"==typeof e&&(a=new Date(e.toString())),r=((new Date).getTime()-a.getTime())/1e3,t=Math.abs(r),n=Math.floor(t/86400),!isNaN(n))return s=r<0?"from now":"ago",t<60?0<=r?"just now":"in a moment":t<120?"1 minute "+s:t<3600?Math.floor(t/60)+" minutes "+s:t<7200?"1 hour "+s:t<86400?Math.floor(t/3600)+" hours "+s:1===n?0<=r?"Yesterday":"Tomorrow":n<7?n+" days "+s:7===n?"1 week "+s:n<31?Math.ceil(n/7)+" weeks "+s:"more than 5 weeks "+s},toBrowserTimeZone:function(e,a){return this.date(new Date(e),a||"MM/dd/yyyy HH:mm:ss")}}}()}(),jQuery.format=DateFormat.format;

</script>
<script>
$( document ).ready(function() {
  
  $("<style id='height_style'>.timeline::after {height: "+$('#timeline_box')[0].scrollHeight +"px;}</style>").insertBefore("#timeline_box");
   

});



$('#selectAll').click(function(){
  $("input[name='column_show']").prop('checked', true);
 // $(".column_show").attr('checked', 'checked');
  //$('.column_show').trigger('click')
  $.uniform.update();
  get_events();
})

$('#selectNone').click(function(){
  $("input[name='column_show']").prop('checked', false);
 // $(".column_show").attr('checked', 'checked');
  //$('.column_show').trigger('click')
  $.uniform.update();
  get_events();
})

$('.column_show').click(function(){
  
      //$('.proposal_events').hide();
        var event_types = [];
        $.each($("input[name='column_show']:checked"), function(){
          event_types.push($(this).val());
            });

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('ajax/getProposalEventsByType') ?>",
                data: {
                                proposal_id: <?=$proposal->getProposalId();?>,
                                types : event_types
                            },
                dataType: 'json'
            })
                .done(function (data) {
                  var events_html = '';
                  var month ='';
                  var year = '';
                  if(data.success){
                    var data = data.events;
                    if(data.length>0){
                      for($i=0;$i<data.length;$i++){
                        
                        var c_month = $.format.date(data[$i].created_at, "MMMM");
                        var c_year = $.format.date(data[$i].created_at, "yyyy");
                        if(month==c_month && year==c_year){}else{
                          events_html +='<p style="font-size:14px;padding-left: 60px;font-weight: bold;"><i class="fa fa-fw fa-calendar"></i> '+c_month+' '+c_year+'</p>';
                          month = c_month;
                          year = c_year;
                        }
                        var date = $.format.date(data[$i].created_at, "MMM dd, yyyy h:mmp");
                          if(data[$i].fullName){
                            var user_name = data[$i].fullName;
                          }else{
                            var user_name = data[$i].user_name;
                          }
                          events_html +='<div class="container right " >'+
                          '<div class="content" style="padding-left: 5px;">'+
                          '<span style="float: left;margin-top: 20px;min-height: 50px;padding-right: 5px;"><i class="fa fa-2x fa-fw '+data[$i].type_icon+'"></i></span>'+
                          '<p><span style="font-size:13px;font-weight:bold;">'+date+'</span><span style="font-size:13px;font-weight:bold;float:right"><i class="fa fa-fw fa-user"></i> '+user_name+'</span></p>'+
                          '<p style="margin-top: 10px;"><span>'+data[$i].event_text+'.</span>';
                          if(data[$i].ip_address){
                            events_html +='<a href="/account/ipMap/'+data[$i].ip_address+'" class="show_location_map fancybox fancybox.iframe tiptip" title="View Location" style="float:right;">'+data[$i].ip_address+'</a></p></div></div>';
                          }else{
                            events_html +='</p></div></div>';
                          }
                      }

                      $('#timeline').html(events_html);
                      initTiptip();
                      $('#height_style').remove();
                      $("<style id='height_style'>.timeline::after {height: "+$('#timeline_box')[0].scrollHeight +"px;</style>").insertBefore("#timeline_box");
                    }else{
                      $('#timeline').html('<h4 style="text-align:center">No Events</h4>');
                    }
                  }else{
                    $('#timeline').html('<h4 style="text-align:center">No Events</h4>');
                  }
                })
                .fail(function (xhr) {
                    swal(
                        'Error',
                        'There was an error : ' + xhr.responseText
                    );
                });



          
      });


function get_events(){
  
  //$('.proposal_events').hide();
    var event_types = [];
    $.each($("input[name='column_show']:checked"), function(){
      event_types.push($(this).val());
        });

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('ajax/getProposalEventsByType') ?>",
            data: {
                            proposal_id: <?=$proposal->getProposalId();?>,
                            types : event_types
                        },
            dataType: 'json'
        })
            .done(function (data) {
              var events_html = '';
              var month ='';
                  var year = '';
              if(data.success){
                var data = data.events;

                if(data.length>0){
                  for($i=0;$i<data.length;$i++){
                    var c_month = $.format.date(data[$i].created_at, "MMMM");
                        var c_year = $.format.date(data[$i].created_at, "yyyy");
                        if(month==c_month && year==c_year){}else{
                          events_html +='<p style="font-size:14px;padding-left: 60px;font-weight: bold;"><i class="fa fa-fw fa-calendar"></i> '+c_month+' '+c_year+'</p>';
                          month = c_month;
                          year = c_year;
                        }
                    var date = $.format.date(data[$i].created_at, "MMM dd, yyyy h:mmp");

                      
                      if(data[$i].fullName){
                        var user_name = data[$i].fullName;
                      }else{
                        var user_name = data[$i].user_name;
                      }
                      events_html +='<div class="container right " >'+
                      '<div class="content" style="padding-left: 5px;">'+
                      '<span style="float: left;margin-top: 20px;min-height: 50px;padding-right: 5px;"><i class="fa fa-2x fa-fw '+data[$i].type_icon+'"></i></span>'+
                      '<p><span style="font-size:13px;font-weight:bold;">'+date+'</span><span style="font-size:13px;font-weight:bold;float:right"><i class="fa fa-fw fa-user"></i> '+user_name+'</span></p>'+
                      '<p style="margin-top: 10px;"><span>'+data[$i].event_text+'.</span>';
                          if(data[$i].ip_address){
                            events_html +='<a href="/account/ipMap/'+data[$i].ip_address+'" class="show_location_map fancybox fancybox.iframe tiptip" title="View Location" style="float:right;">'+data[$i].ip_address+'</a></p></div></div>';
                          }else{
                            events_html +='</p></div></div>';
                          }
                  }

                  $('#timeline').html(events_html);
                  $('#height_style').remove();
                  initTiptip();
                  $("<style id='height_style'>.timeline::after {height: "+$('#timeline_box')[0].scrollHeight +"px;</style>").insertBefore("#timeline_box");
                }else{
                  $('#timeline').html('<h4 style="text-align:center">No Events</h4>');
                }
              }else{
                $('#timeline').html('<h4 style="text-align:center">No Events</h4>');
              }
            })
            .fail(function (xhr) {
                swal(
                    'Error',
                    'There was an error : ' + xhr.responseText
                );
            });



      
  };
</script>