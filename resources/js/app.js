var myApp = angular.module('myApp',[]);

myApp.controller('Search', function ($scope, $http) {
 // - GET THE DEFAULT CONNECTION STRINGS
 // - CONNECT TO IT
	// IF ONLINE
	// - ONLINE STATUS
	// - GET THE PARAMETERS
        // - SHOW PARAMS
	// IF OFFLINE
	// - OFFLINE STATUS
	// - DONT GET PARAMS
        // - DISPLAY ERROR
        $http.get(base_url+'/params/preset',{headers: {'Content-Type': 'application/json'}}).
            then(function(data) {
                $scope.server = data.data[0].Server;
                $scope.instance = data.data[0].Instance;
                $scope.username = data.data[0].Username;
                $scope.password = data.data[0].Password;
                
                status("hidden");
                loader("show");
                conn_db_req($scope.server);
                
            }, function(response) {
                loader("hide");
            });
            
	function conn_db_req(server){
		var req = {
		 method: 'POST',
		 url: base_url+'/params/search',
		 headers: {
			'Content-Type': 'application/json'
		 },
		data: {
			'server' : $scope.server,
			'instance' : $scope.instance,
			'username' : $scope.username,
			'password' : $scope.password,
                        'save' : $scope.saveconn
			}
		};
		
                status("hidden");    
                loader("show");
                
		$http(req).
		success(function(data) {
                        loader("hide");
                        status("online");
                        $scope.results = data;  // DISPLAY PARAMS
                        $scope.msg = {data:'Online to', server:server};
                        $('#search').focus();
		}).
		error(function(data) {
                        loader("hide");
			status("offline");
                        $scope.msg = {data:'Offline to', server:server};
                        $scope.results = data;
		});
	}	// function conn_db_req() end
        
        function getdetails(group, field){
            var req = {
            method: 'POST',
            url: base_url+'/params/details',
            headers: {
                   'Content-Type': 'application/json'
               },
           data: {
                   'server' : $scope.server,
                   'instance' : $scope.instance,
                   'username' : $scope.username,
                   'password' : $scope.password,
                   'group' : group,
                   'field' : field
               }
           };

           $http(req).
           success(function(data) {
               $scope.info = data.infos[0];
               $scope.option = data.option;
               $scope.defval = data.defval;
               $('#ParamInfo').modal('show');
               console.log(data.defval);
           }).
           error(function(data) {
               console.log("error getdetails()");
           });
//            console.log(group, field)
        }   // function getdetails() end
        
        function getgroupdetails(group){
            var req = {
            method: 'POST',
            url: base_url+'/params/group',
            headers: {
                   'Content-Type': 'application/json'
               },
           data: {
                   'server' : $scope.server,
                   'instance' : $scope.instance,
                   'username' : $scope.username,
                   'password' : $scope.password,
                   'group' : group
               }
           };

           $http(req).
           success(function(data) {
               $scope.grp = data;
               $('#GroupInfo').modal('show');
               console.log(data);
           }).
           error(function() {
               console.log("error getgroupdetails()");
           });
        }   // function getgroupdetails() end
        
        function loader(opt){
            var elem = angular.element('#loader');
            if(opt==="show"){
                elem.show();	//	SHOW LOADER
                var spinner = document.getElementById("settings");
                spinner.className = spinner.className="spinmenow";
//                console.log(spinner);
            }else{
                elem.hide();     //	HIDE LOADER
                var spinner = document.getElementById("settings");
                spinner.className = spinner.className="spin";
            }
        }
        
        function status(status){
            var ele = document.getElementById("status");
            var status_icon = document.getElementById("navicn-status");
            
            ele.className = ele.className=status;
            
            if(status==="online"){
                status_icon.className = status_icon.className="glyphicon glyphicon-ok-circle";
            }else{
                status_icon.className = status_icon.className="glyphicon glyphicon-remove-circle";
            }
        }
		
	$scope.submit = function(){
		conn_db_req($scope.server);
		$('#ConnSettings').modal('hide');
	};

	$scope.clear = function(){
              $scope.query = {};
        };
        
        $scope.getdetails = function(group, field){
            getdetails(group, field)
        };
        
        $scope.getgroupdetails = function(group){
            getgroupdetails(group)
        };
                
});

myApp.controller('test', function ($scope, $http) {
    
});

myApp.controller('Users', function ($scope, $http) {
//    $scope.store="111";
    var server = $scope.server = "";
    var instance = $scope.instance = "NCRWO";
    var username = $scope.username = "rteuser";
    var password = $scope.password = "RTE$t0re";
    
    modal_toggle();

    function modal_toggle(){
        if(server===""){
            $('#ConnSettings').modal('show');
            $('#server').focus();
            document.getElementById("search").disabled=true;
        }
    }
    
    function conn_db_req(server){
        var req = {
         method: 'POST',
         url: base_url+'/users/connect',
         headers: {
                'Content-Type': 'application/json'
         },
        data: {
                'server' : $scope.server,
                'instance' : $scope.instance,
                'username' : $scope.username,
                'password' : $scope.password
                }
        };

        status("hidden");    
        loader("show");
        document.getElementById("search").disabled=true;

        $http(req).
        success(function() {
            loader("hide");
            status("online");
            document.getElementById("search").disabled=false;
            $scope.msg = {data:'Online to', server:server};
            $('#store').focus();
        }).
        error(function() {
            loader("hide");
            status("offline");
            $scope.msg = {data:'Offline to', server:server};
        });
    }	// function conn_db_req() end
    
    function search(){
        var req = {
         method: 'POST',
         url: base_url+'/users/search',
         headers: {
                'Content-Type': 'application/json'
            },
        data: {
                'server' : $scope.server,
                'instance' : $scope.instance,
                'username' : $scope.username,
                'password' : $scope.password,
                'store' : $scope.store
            }
        };
        
        $http(req).
        success(function(data) {
//            console.log(data.data);
            $scope.results = data.data;
            if(typeof data.count === "undefined"){
                $scope.count = "No Records Found :(";
            }
            else{
                $scope.count = "Displaying "+data.count+" Records:";
            }

        }).
        error(function(data) {
            console.log(data);
        });
    }	// function search() end
    
    function details(userid){
        var req = {
         method: 'POST',
         url: base_url+'/users/details',
         headers: {
                'Content-Type': 'application/json'
            },
        data: {
                'server' : $scope.server,
                'instance' : $scope.instance,
                'username' : $scope.username,
                'password' : $scope.password,
                'store' : $scope.store,
                'userid' : userid
            }
        };
        
        $http(req).
        success(function(data) {
            $scope.info = data;
            $('#UserInfo').modal('show');
            console.log(data);
        }).
        error(function(data) {
            console.log(data);
        });
    }	// function details() end
    
    function unlock(userid){
        var req = {
         method: 'POST',
         url: base_url+'/users/unlock',
         headers: {
                'Content-Type': 'application/json'
            },
        data: {
                'server' : $scope.server,
                'instance' : $scope.instance,
                'username' : $scope.username,
                'password' : $scope.password,
                'userid' : userid
            }
        };
        
        $http(req).
        success(function(data) {
//            $scope.results = data;
            console.log(data.msg);
//            alert(data.msg);
            search();
        }).
        error(function(data) {
            console.log(data);
        });
    }	// function unlock() end
    
    function loader(opt){
        var elem = angular.element('#loader');
        if(opt==="show"){
            elem.show();	//	SHOW LOADER
            var spinner = document.getElementById("settings");
            spinner.className = spinner.className="spinmenow";
//                console.log(spinner);
        }else{
            elem.hide();     //	HIDE LOADER
            var spinner = document.getElementById("settings");
            spinner.className = spinner.className="spin";
        }
    }
        
    function status(status){
        var ele = document.getElementById("status");
        var status_icon = document.getElementById("navicn-status");

        ele.className = ele.className=status;

        if(status==="online"){
            status_icon.className = status_icon.className="glyphicon glyphicon-ok-circle";
        }else{
            status_icon.className = status_icon.className="glyphicon glyphicon-remove-circle";
        }
    }
    
    $scope.connect = function(){
        conn_db_req($scope.server);
        modal_toggle();
        $('#ConnSettings').modal('hide');
        $scope.store="";
        $scope.results="";
        $scope.count="";
    };
    
    $scope.search = function(){
        search();
    };
    
    $scope.more = function(userid){
        details(userid)
    };
    
    $scope.unlock = function(userid){
        unlock(userid)
    };
    
});