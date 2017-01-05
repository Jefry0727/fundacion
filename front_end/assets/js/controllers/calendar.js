'use strict';

angular.module('app')
    .controller('calendarCtrl', [

      '$scope',
      
      '$state',
      
      '$rootScope',
      
      '$localStorage',
      
      'medicalOfficesService',
      
      '$compile',

      'appointmentService',
      
      'uiCalendarConfig',

      'ordersService',


     function(

       $scope, 
       
       $state, 
       
       $rootScope, 
       
       $localStorage, 
       
       medicalOfficesService, 
       
       $compile,

       appointmentService,

       uiCalendarConfig,

       ordersService

       ) {

         // USADO PARA LA COMPATIBILIDAD CON CHROME

         if (!Object.prototype.watch) {
          Object.defineProperty(Object.prototype, "watch", {
              enumerable: false
            , configurable: true
            , writable: false
            , value: function (prop, handler) {
              var
                oldval = this[prop]
              , newval = oldval
              , getter = function () {
                return newval;
              }
              , setter = function (val) {
                oldval = newval;
                return newval = handler.call(this, prop, oldval, val);
              }
              ;
              
              if (delete this[prop]) { // can't watch constants
                Object.defineProperty(this, prop, {
                    get: getter
                  , set: setter
                  , enumerable: true
                  , configurable: true
                });
              }
            }
          });
         }

        // object.unwatch
        if (!Object.prototype.unwatch) {
          Object.defineProperty(Object.prototype, "unwatch", {
              enumerable: false
            , configurable: true
            , writable: false
            , value: function (prop) {
              var val = this[prop];
              delete this[prop]; // remove accessors
              this[prop] = val;
            }
          });
        }

         // --USADO PARA LA COMPATIBILIDAD CON CHROME


        
        
        
        /* -------FORMULARIO-------- */
        function Formulario(){

          this.center         = '';
          this.date           = moment( new Date() ).format('YYYY-MM-DD');
          // Lista de consultorios
          this.medicalOffices = new Array();
          // Lista de cedes
          this.centers        = new Array();
          var _this           = this;

          // Poner el calendario en el campo de fecha
          $("[name=fecha]").datepicker({
            format : "yyyy-mm-dd"
          });

          
          // Obtiene una lista de las sedes
          ordersService.getCenters( 
            function( success ){
              _this.centers = success.center;
            },
            function( error ){

            } );

          // Obtiene la lista de consultorios segun la sede
          this.getMedicalOffices = function( centerId ){
            medicalOfficesService.getMedicalByCenter(
              {
                id: centerId
              },
              function( res ){
                l( "Respuesta" );
                l( res );
                _this.medicalOffices = res.medicalOffices;
              },
              function( res ){

              }
            );
          }

          // Obtiene la lista de consultorios cuando se obtiene se selecciona una sede
          _this.watch('center', function( id, oldval, newval ){
            
            _this.medicalOffices = [];
            _this.getMedicalOffices( newval );
            return newval;
          } );



        }
        /* -------./FORMULARIO-------- */

        /*----------CALENDARIO---------- */
        function Calendario(){
          
          this.config = {
            defaultView : 'agendaDay',
            monthNames  : [ 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
              'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
            ],
            dayNames     : [ 'Domingo', 'Lunes', 'Martes', 'Miercoles' ,
              'Jueves', 'Viernes', 'Sabado'
            ],
            buttonText   : { 
              month:    'Mes',
              week:     'Semana',
              day:      'Día',
              list:     'Lista'
            },
            slotDuration  : '00:05:00',
            height        : 600,
            minTime       : '7:00',
            maxTime       : '18:00',
            eventColor: '#6B5C2',
            header: {
              right: 'prev, next' 
            },
            viewRender   : function(view, element) {
              var b = $('#scheduler').fullCalendar('getDate');
              // sumamos un dia a la fecha seleccionada 
              b = moment(b).add('days', 1);
              // damos formato a la fecha seleccionada 
              b = moment( b._d ).format('YYYY-MM-DD');

              $('[name=fecha]').val( b );
              $scope.Formulario.date = b;
              l( b );
              // $('[name=fecha]').trigger('input');
            }
          };

          // citas del dia
          var citas = [];
          
          var _this = this;
          
          $(".fc-corner-left").prop('ng-click', 'Calendario.getEventos()' );
          // Inicializa el Calendario
          $("#scheduler").fullCalendar( this.config );

          
          // -------METODOS-------
          

          // Obtiene los eventos
          this.getEventos = function(){
            
            // checa que los datos esten completos
            if( !$scope.Formulario.medicalOffice || $scope.Formulario.medicalOffice.length ==0 || !$scope.Formulario.date || $scope.Formulario.date.length ==0 ){

              $( '[name=error-mesage]' ).show(250);
              return;

            }
            
            $( '[name=error-mesage]' ).hide(250);

            appointmentService.getAppointmentsDay(
              {
                idMedical : $scope.Formulario.medicalOffice,
                dateDay   : $scope.Formulario.date,
              },
              function( success ){
                _this.citas = success.appointments;
              },  
              function( error ){

                l('getEventos()');
                l( error );
              }

            );
      
          }


          // Formatea la fecha de los eventos
          _this.watch( 'citas', function( id, oldval, newval ){
            
            $("#scheduler").fullCalendar( 'removeEvents');
            var cita  = {};
            var citas = [];
            var fecha = moment( $scope.Formulario.date, "YYYY-MM-DD" );

            for( var index in newval ){
              cita = {};
  
              cita.start = newval[ index ].date_time_ini;
              cita.end   = newval[ index ].date_time_end;
              cita.title = newval[ index ].identification + " " +newval[ index ].name  +' - ' +newval[index].appointment.study.name + ' Agendado por : ' + 
              newval[index].user.person.first_name +' '+  newval[index].user.person.last_name;

              citas.push( cita );
            }


            citas.push({
                start: '12:00:00',
                end: '14:00:00',
                rendering: 'background',
                overlap: true,
                color: '#C5DDC1'
              });
            _this.config.defaultDate = $scope.Formulario.date;
          

            $("#scheduler").fullCalendar( 'gotoDate', fecha.format('YYYY-MM-DD') );
            $("#scheduler").fullCalendar( 'addEventSource', citas );


            return citas;
          } );


        }
        /*----------CALENDARIO---------- */



        $scope.Formulario = new Formulario();
        $scope.Calendario = new Calendario();



    }
  ]
);









