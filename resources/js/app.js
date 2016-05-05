var PSApp = angular.module('PSApp',['infinite-scroll']);
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
        $scope.username = 'rteuser';
        $scope.password = 'RTE$t0re';
        
        $http.get(base_url+'/api/preset',{headers: {'Content-Type': 'application/json'}}).
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
                $('#ConnSettings').modal('show');
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

myApp.controller('Users', function ($scope, $http) {
    var server = $scope.server = "";
    var instance = $scope.instance = "";
    var username = $scope.username = "rteuser";
    var password = $scope.password = "RTE$t0re";
    
    $http.get(base_url+'/api/preset',{headers: {'Content-Type': 'application/json'}}).
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
                modal_toggle();
            });

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

PSApp.controller('POSLog', function($scope, $http, $anchorScroll) {
    var server = $scope.server = "";
    var instance = $scope.instance = "";
    var username = $scope.username = "rteuser";
    var password = $scope.password = "RTE$t0re";
    $scope.table = 'Transactions';
    $scope.store = '';
    $scope.term = '';
    $scope.trans = '';
    $scope.transtype = null;
    $scope.end = false;
    $scope.types = '';
    $scope.idSelected = null;
    
    $http.get(base_url+'/api/preset',{headers: {'Content-Type': 'application/json'}}).
            then(function(data) {
                $scope.server = data.data[0].Server;
                $scope.instance = data.data[0].Instance;
                $scope.username = data.data[0].Username;
                $scope.password = data.data[0].Password;
                
                status("hidden");
                loader("show");
                conn_db_req($scope.server, $scope.table, $scope.store, $scope.term, $scope.trans, $scope.transtype);
            }, function(response) {
                loader("hide");
                modal_toggle();
            });
    
    function modal_toggle(){
        if(server===""){
            $('#ConnSettings').modal('show');
            $('#server').focus();
            document.getElementById("search").disabled=true;
        }
    }
    
    function conn_db_req(server, table, store, term, trans, transtype){
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
        $scope.items = [];
        document.getElementById("search").disabled=true;

        $http(req).
        success(function() {
            loader("hide");
            status("online");
            document.getElementById("search").disabled=false;
            $scope.msg = {data:'Online to', server:server};
            $scope.after = 0;
            $scope.end = false;
            $anchorScroll("#top");
            $scope.loadMore(table, store, term, trans, transtype);
        }).
        error(function() {
            loader("hide");
            status("offline");
            $scope.msg = {data:'Offline to', server:server};
        });
    }	// function conn_db_req() end
    
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
    
    $scope.loadMore = function(table, store, term, trans, transtype) {
        if(($scope.server!=="") && ($scope.after / 10 % 1 === 0)){
            if (this.busy) return;
            this.busy = true;
            
            var req = {
            method: 'POST',
            url: base_url+'/poslog/search',
            headers: {
                   'Content-Type': 'application/json'
            },
            data: {
                   'server' : $scope.server,
                   'instance' : $scope.instance,
                   'username' : $scope.username,
                   'password' : $scope.password,
                   'i' : parseInt(this.after),
                   'table' : table,
                   'store' : store,
                   'term' : term,
                   'trans' : trans,
                   'transtype' : transtype
                   }
            };
            
            $http(req).
            success(function(data) {
                $scope.types = data[1];
                var items = data[0];
                for (var i = 0; i < items.length; i++) {
                    this.items.push(items[i]);
                }
                this.after = this.items[this.items.length - 1].RowNum;
                this.busy = false;
                
                $scope.layout = table;
            }.bind(this)).
            error(function(status) {
                if(status !=="") console.log(status);
                $scope.end = true;
                $scope.busy = false;
            });
        }
    };
    
    $scope.connect = function(){
        $('#ConnSettings').modal('hide');
        $scope.table = 'Transactions';
        $scope.store = null;
        $scope.term = null;
        $scope.trans = null;
        $scope.transtype = null;
        //        conn_db_req($scope.server, $scope.table, $scope.store, $scope.term, $scope.trans, $scope.transtype);
        conn_db_req($scope.server, $scope.table,'','','','');
    };
    
    $scope.search = function(table, store, term, trans, transtype){
        $scope.items = [];
        $scope.after = 0;
        $scope.end = false;
        $scope.loadMore(table, store, term, trans, transtype);
        $anchorScroll("#top");
        $scope.layout = table;
    };
    
    $scope.setSelected = function(idSelected){
        $scope.idSelected = idSelected;
    };
    
});

PSApp.directive('tooltip', function(){
    return {
        restrict: 'A',
        link: function(scope, element, attrs){
            $(element).hover(function(){
                // on mouseenter
                $(element).tooltip('show');
            }, function(){
                // on mouseleave
                $(element).tooltip('hide');
            });
        }
    };
});
