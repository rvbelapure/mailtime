var localTimeZone = -4;
var chart;
var dataForGraph = new Array();
var originalDataForGraph;
var notificationRanks = new Array(10, 16, 20, 22 , 11, 8);
var timespan = 1;
var username;
var password;
var parsedJson = new Array();
var hoursArray = new Array('12am', '1am', '2am', '3am', '4am', '5am',
      '6am', '7am', '8am', '9am', '10am', '11am', '12pm', '1pm', '2pm', '3pm', '4pm', '5pm', '6pm', '7pm', '8pm', '9pm', '10pm', '11pm');
var loadingHTML = '<div style="color:#D90000; text-align:center; margin-top:100px;"><img src="assets/img/loading.gif" style="margin-left:10px;"/><br/><h4>We are analyzing your inbox.</h4><h3>A little patience = Lot of magic</h3></div>';
var volatility;

function loginUser(){
  username = $("#username").val();
  password = $("#password").val();
  changePage();
  $("#user-profile").html("Welcome "+username);
  loadData();
}
function loadData(){
  $("#container").html(loadingHTML);
  var jsonData = $.ajax({
    type: 'POST',
    url: "login_action.php",
    data: {uname: username, passwd: password, timespan: timespan},
    dataType:"json",
    async: false
  }).done(function(data) { 
    // Parse the JSON..
    parsedJson = [];
    for(var i = 0; i < 24; i++) {
    var obj = { "hour": i, "emails": [] };
      parsedJson.push(obj);
    }
    for(var i = 0; i < data.email.length; i++) {
      var date = new Date(data.email[i].date * 1000);
      var time = (date.getUTCHours() + localTimeZone)%24;
      if (time < 0) {
        time += 24;
      }
      parsedJson[time].emails.push(data.email[i]);
    }
    var memberfilter = new Array();
    memberfilter[0] = "from";
    //var jsonText = JSON.stringify(contact, memberfilter, "\t");
    console.log("parsed json");
    console.log(parsedJson);                        
    dataForGraph = [];
    jQuery.each(parsedJson, function(index, value) {
      dataForGraph.push(value.emails.length);
    });
    originalDataForGraph = dataForGraph.slice(0);

    // Time Recommendations
    
    // hourly e-mail volume: parsedJson[i].emails.length
    // total e-mail volume: data.email.length;
    // average e-mail volume: data.email.length / 24;
    
    // initialize variables
    var accumulatedEmails = 0;
    var accumulatedEmailsHourly = [];
    volatility = [];
    var emailVolume = []; // will be trashed to get a median.
    var median = 0;
    var average = data.email.length / 24;
    for (var i = 0; i < parsedJson.length; i++) {
      emailVolume[i] = parsedJson[i].emails.length;
      accumulatedEmailsHourly[i] = 0;
      volatility[i] = 0;
    }
    median = getMedian(emailVolume);
    for (var i = 0; i < parsedJson.length; i++) {
      accumulatedEmails += parsedJson[i].emails.length;
      accumulatedEmailsHourly[i] = accumulatedEmails;
      
      //if (parsedJson[i].emails.length > average) {
      if (parsedJson[i].emails.length > median) {
        if (i > 0) {
          volatility[i] = volatility[i-1] + 1;
        } else {
          volatility[i] = 1;
        }
      }
    }
    // Temp hack for getting the longest run.
    var longestRun = 0;
    var longestRunLength = 0;
    for (var i = 0; i < volatility.length; i++) {
      if (volatility[i] > longestRunLength) {
        longestRunLength = volatility[i];
        longestRun = i;
      }
    }
    // Set up a single notification.
    notificationRanks[0] = longestRun+1;
    
  });
  drawChart(dataForGraph);  
  addMarker(1);
}
function drawChart(chartData){
  chart = new Highcharts.Chart({
    chart: {
      renderTo: 'container',
      type: 'area'
    },
    title: {
      text: 'Your hourly distribution of emails'
    },
    subtitle: {
      text: 'Based on emails from the last '+timespan+' month(s)'
    },
    xAxis: {
    categories: hoursArray
    },
    yAxis: {
      title: {
        text: 'No of emails'
      },
      labels: {
        formatter: function() {
          return this.value +' mails'
        }
      }
    },
    tooltip: {
      crosshairs: true,
      shared: true
    },
    plotOptions: {
      spline: {
        marker: {
          radius: 4,
          lineColor: '#666666',
          lineWidth: 1
        }
      },
       series: {
        lineColor: '#d90000',
        allowPointSelect: true,
        cursor: 'pointer',
        point: {
          events: {
            click: function() {
            var tempVar = $.inArray(this.category, hoursArray);
            var displayTableStart = '<table class="table table-striped"><thead><tr><th>People who have sent you emails in this hour</th></tr></thead><tbody>';
            var displayTableEnd = '</tbody></table>';
            jQuery.each(parsedJson, function(index, value) {
              if (value.hour == tempVar){
                jQuery.each(value.emails, function(index, value) {
                  displayTableStart += '<tr><td>'+value.from+'</td></tr>';
                });
                displayTableStart += displayTableEnd;
                $("#hourModalBody").html(displayTableStart);
              }
            });                        
            $('#hourModal').modal({
              show:true
            });
            }
          }
        }
      }
    },
    series: [{
      name: 'Total mails / hour',
      marker: {
        symbol: 'circle'
      },
      data: chartData,
       color: '#ee6464'
    }],
    navigation: {
      buttonOptions: {
        enabled: false
      }
    }
  });
}
function addMarker(element){
  var option_user_selection = null;
  if (typeof(element) == "object") {
    option_user_selection = element.options[ element.selectedIndex].text;
  } else {
    option_user_selection = element;
  }
  dataForGraph = originalDataForGraph.slice(0);
  for (i = 0; i<option_user_selection; i++){
    dataForGraph[notificationRanks[i]] = {y: dataForGraph[notificationRanks[i]], marker: { symbol: 'url(assets/img/email'+(i+1)+'.png)'}};
  }
  drawChart(dataForGraph);
}
function changeTimespan(element, inputTimespan){
  timespan = inputTimespan;
  $(".month-buttons > button").removeClass("active");
  $(element).addClass("active");
  loadData();
  drawChart(dataForGraph);  
}
function changePage(){
  $("#login-container").toggle();
  $("#user-container").toggle();
}
function getMedian(values) {
    values.sort( function(a,b) {return a - b;} );
    var half = Math.floor(values.length/2);

    if(values.length % 2)
      return values[half];
    else
      return (values[half-1] + values[half]) / 2.0;
}