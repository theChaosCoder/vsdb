<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'VSDB - Vapoursynth Database') }}</title>


    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.semanticui.min.css">
    <style>
        @import url('//cdn.datatables.net/1.10.2/css/jquery.dataTables.css');
        table.dataTable tr.group td {
            font-weight: bold;
            background-color: #1DB565
        }


        td.details-control {
            background: url('http://www.datatables.net/examples/resources/details_open.png') no-repeat center center;
            cursor: pointer;
        }

        tr.shown td.details-control {
            background: url('http://www.datatables.net/examples/resources/details_close.png') no-repeat center center;
        }

        #vsdb_wrapper {
            margin-top: 10px !important;
            margin-bottom: 10px !important;
        }

        .group {
            font-size: 15pt;
            color: white;
        }
        #vsdb_filter  input { width: 220px }
        .vsdb-full {
            margin-left: 14px !important;
            margin-right: 14px !important;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.semanticui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.js"></script>
    <script src="https://cdn.datatables.net/rowgroup/1.0.4/js/dataTables.rowGroup.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>

    <script type="text/javascript" class="init">
        //$(document).ready(function() {
         //	$('#vsdb').DataTable();
         //});

         function format(value) {
           return '<div>' + value + '</div>';
          }
         $(document).ready(function() {
         var table = $('#vsdb').DataTable( {
			//fixedHeader: true,
			iDisplayLength: 100,
         	orderFixed: [4, 'asc'],
         	rowGroup: {
         		endRender: null,
         		startRender: function ( rows, group ) {
         			return group +' ('+rows.count()+')';
         		},
         		dataSrc: 4
         	},
			"order": [[ 1, "asc" ]]
         });

         // Add event listener for opening and closing details
             $('#vsdb').on('click', 'td.details-control', function () {
                 var tr = $(this).closest('tr');
                 var row = table.row(tr);

                 if (row.child.isShown()) {
                     // This row is already open - close it
                     row.child.hide();
                     tr.removeClass('shown');
                 } else {
                     // Open this row
                     row.child(format(tr.data('child-value'))).show();
                     tr.addClass('shown');
                 }
             });

          // Handle click on "Expand All" button
           $('#btn-show-all-children').on('click', function(){
               // Expand row details
               table.rows(':not(.parent)').nodes().to$().find('td:first-child').trigger('click');
           });

			table.on('page.dt', function() {
			  $('html, body').animate({
				scrollTop: $(".dataTables_wrapper").offset().top
			  }, 'fast');
			});


			/* Custom filtering function GPU */
			$.fn.dataTable.ext.search.push(
				function( settings, data, dataIndex ) {
					var gpu =  data[5]; // use data for the gpu column
					var gpucheck = $('#gpu').is(':checked');

					if (!gpucheck)  {
						return true;
					} else {
						if (gpu != "")  {
							return true;
						}
					}
					//console.log(gpu);
					return false;
				}
			);
			// Event listener checkbox
				$('#gpu').change( function() {
					table.draw();
				});

				$('#plugin').change( function() {
					table.draw();
				});

         }); // doc ready
    </script>
</head>

<body>
    <div id="app">

        <main>
            @yield('content')
        </main>
    </div>
</body>

</html>
