<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>J2 - <?php echo $titulo; ?></title>
    <!--
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;700;900&display=swap" rel="stylesheet"> -->
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  
<link href="https://fonts.googleapis.com/css2?family=Iceberg&family=Tektur:wght@400..900&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/v/dt/dt-2.0.3/r-3.0.1/datatables.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <link rel="stylesheet" href="/build/css/tailwindapp.css">
    <link rel="stylesheet" href="/build/css/app.css">
    <link rel="icon" type="image/x-icon" href="/build/img/favicon.ico"/>
    
</head>
<body class="dashboardno">
    <div class="dashboard">
        <?php include_once __DIR__."/templates/sidebar.php"; ?> <!-- barra lateral -->

        <div class="principal">
            <?php include_once __DIR__."/templates/header.php"; ?>  <!-- barra superior -->

            <div class="contenido">
                <h2 class="nombre-pagina"><?php //echo $titulo; ?></h2>
                <?php echo $contenido; ?>
            </div>
        </div>
    </div>

    <?php //$script = '<script src="build/js/app.js"></script>'; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-2.0.3/r-3.0.1/datatables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    
    <!--<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js" integrity="sha256-alsi6DkexWIdeVDEct5s7cnqsWgOqsh2ihuIZbU6H3I=" crossorigin="anonymous"></script>-->
    <!--<script src="/build/js/bundle.min.js" defer></script>-->
    <script src="/build/js/bundle.ts.min.js" defer></script>

    <script>
        //$("#flatpickr").flatpickr({inline: true, disableMobile: "false"});
        
        /*var picker = new Pikaday({ field: document.getElementById('datepicker')});
        picker.show();*/
        
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            //theme: true,
            headerToolbar: {right: '', left: '', center: 'title'},
            titleFormat: {year: 'numeric', month: 'long'},
            contentHeight: 250,
            aspectRatio: 1,
            initialView: 'dayGridMonth',
            locale: 'es',
            dayCellDidMount: function(arg) {
                var today = new Date(); // Obtener la fecha actual
                if (arg.date.getDate() === today.getDate() &&arg.date.getMonth() === today.getMonth() &&arg.date.getFullYear() === today.getFullYear()) {
                    // Personaliza la celda del día actual
                    arg.el.style.backgroundColor = '#007df4'; // Cambia el color de fondo
                    //arg.el.style.border = '2px solid blue'; // Agrega un borde
                    var dayNumberElement = arg.el.querySelector('.fc-daygrid-day-number');
                    dayNumberElement.style.color = 'white';
                    dayNumberElement.style.fontSize = '1.8rem';
                    dayNumberElement.style.fontWeight = '700';
                }
            },
            dayHeaderContent: function(arg) {
                return ''; // Reemplaza el contenido del encabezado con una cadena vacía
            },
            datesSet: function(dateInfo) {
                var titleElement = document.querySelector('.fc-toolbar h2'); // Selecciona el elemento del título
                titleElement.style.fontSize = '15px'; // Cambia el tamaño de la letra
                titleElement.style.color = '#6b7280'; // Cambia el color del texto
                var dayCells = document.querySelectorAll('.fc-daygrid-day');
                dayCells.forEach(function(cell) {
                    cell.style.height = '30px'; // Ajustar la altura de las celdas
                });
            }
        });
        calendar.render();
        
    </script>
</body>
</html>