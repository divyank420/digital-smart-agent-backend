$(function() {
    "use strict";

	
// chart 1

  var ctx = document.getElementById("chart1").getContext('2d');
   
  var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
      gradientStroke1.addColorStop(0, '#6078ea');  
      gradientStroke1.addColorStop(1, '#17c5ea'); 
   
  var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
      gradientStroke2.addColorStop(0, '#ff8359');
      gradientStroke2.addColorStop(1, '#ffdf40');

      var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
          datasets: [{
            label: 'Laptops',
            data: [65, 59, 80, 81, 65, 59, 80, 60, 59],
            borderColor: '#008cff',
            backgroundColor:  '#008cff',
            hoverBackgroundColor:  '#008cff',
            pointRadius: 0,
            fill: false,
            borderWidth: 0
          }, {
            label: 'Mobiles',
            data: [50, 48, 55, 45, 37, 58, 64, 50, 54],
            borderColor: '#ffc107',
            backgroundColor: '#ffc107',
            hoverBackgroundColor: '#ffc107',
            pointRadius: 0,
            fill: false,
            borderWidth: 0
          }]
        },
		 options:{
		  maintainAspectRatio: false,
		  legend: {
			  position: 'bottom',
              display: true,
			  labels: {
                boxWidth:40
              }
            },
			tooltips: {
			  displayColors:false,
			},	
		  scales: {
			  xAxes: [{
				  barPercentage: .5
			  }]
		     }
		}
      });
});	 
   