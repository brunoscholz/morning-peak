$(function () {

  "use strict";

  //Make the dashboard widgets sortable Using jquery UI
  $(".connectedSortable").sortable({
		placeholder: "sort-highlight",
		connectWith: ".connectedSortable",
		handle: ".box-header, .nav-tabs",
		forcePlaceholderSize: true,
		zIndex: 999999
  });
  $(".connectedSortable .box-header, .connectedSortable .nav-tabs-custom").css("cursor", "move");

  //jQuery UI sortable for the todo list
  $(".todo-list").sortable({
		placeholder: "sort-highlight",
		handle: ".handle",
		forcePlaceholderSize: true,
		zIndex: 999999
  });

  //$(".knob").knob();

  //The Calender
  $("#calendar").datepicker();

  //SLIMSCROLL FOR CHAT WIDGET
  // $('#chat-box').slimScroll({
  //   height: '250px'
  // });

  //Fix for charts under tabs
  $('.box ul.nav a').on('shown.bs.tab', function () {
		area.redraw();
		donut.redraw();
		line.redraw();
  });

  /* The todo list plugin */
  $(".todo-list").todolist({
		onCheck: function (ele) {
		  window.console.log("The element has been checked");
		  return ele;
		},
		onUncheck: function (ele) {
		  window.console.log("The element has been unchecked");
		  return ele;
		}
  });
});

/*$(function () {
  //$("#offer-table").DataTable();
  $('#offer-table table').DataTable({
	"paging": true,
	"lengthChange": false,
	"searching": false,
	"ordering": true,
	"info": true,
	"autoWidth": false
  });
});*/