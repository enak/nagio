// confirm if number is ten digit and not empty
function validateNumber()
{
var x=$("[name=phoneNag]").val();
var y=$("[name=phone]").val();
if (x==null || x=="" || x.length!=10 || y==null || y=="" || y.length!=10)
  {
  alert("Number Can't Be Empty And Must Be 10 Digit Long");
  return false;
  }
}
// make sure email has the proper username,host,domain
function validateEmail()
{
var x=$("[name=emailNag]").val();
var y=$("[name=email]").val();
var atpos=x.indexOf("@");
var dotpos=x.lastIndexOf(".");
var atpos2=y.indexOf("@");
var dotpos2=y.lastIndexOf(".");
if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length || x==null || x=="" || atpos2<1 || dotpos2<atpos2+2 || dotpos2+2>=y.length || y==null || y=="")
  {
  alert("Not a valid e-mail address");
  return false;
  }
}
// check if time if valid and that interval is not longer than duration
function validateTime()
{
var x=$("[name=hours]").val();
var y=$("[name=minutes]").val();
var z=$("[name=duration]").val();
if (x!=0 && (x%1!=0 || y%1!=0 || (x*60)+y<z))
  {
  alert("Not a valid time");
  return false;
  }
}
function validateDur()
{
var x=$("[name=duration").val();
if (x>10080)
  {
  alert("Duration too long");
  return false;
  }
else if(x<0 || x%1!=0)
  {
  alert("Duration not valid");
  return false;
  }
}

$(function(){
$("#pwLabel")

})
