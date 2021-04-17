/*

System alert through Js and PHP


*/
	var $area = $(document),
        idleActions = [
            {
                milliseconds: 3600000, // 60 minute
                action: function () { 
					
					swal({
					  title: "Session Out",
					  text: "Please login again!",
					  type: "warning",
					  showCancelButton: false,
					  confirmButtonClass: "btn-danger",
					  confirmButtonText: "",
					  closeOnConfirm: false,
					  timer: 3000
					},
					function(){ 
						
					  callBackOur();
					  
					});
				}
            }
        ];


	function callBackOur()
	{
		send_data('', 201, '');
		swal( "" , "Refreshing screen ..." );
		setTimeout(function(){location.reload()}, 3000);
	}	
    function Eureka (event, times, undefined) {
        var idleTimer = $area.data('idleTimer');
        if (times === undefined) times = 0;
        if (idleTimer) {
            clearTimeout($area.data('idleTimer'));
        }
        if (times < idleActions.length) {
            $area.data('idleTimer', setTimeout(function () {
                idleActions[times].action(); // run the first action
                Eureka(null, ++times); // setup the next action
            }, idleActions[times].milliseconds));
        } else {
            // final action reached, prevent further resetting
            $area.off('mousemove click', Eureka);
        }
    };

    $area
        .data('idle', null)
        .on('mousemove click', Eureka);

	Eureka();