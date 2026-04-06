<?php
include 'koneksi.php';

// ambil data booking
$data = mysqli_query($conn, "
    SELECT booking.*, lapangan.nama_lapangan, users.nama
    FROM booking
    JOIN lapangan ON booking.lapangan_id = lapangan.id
    JOIN users ON booking.user_id = users.id
    WHERE status != 'rejected'
");

// ubah ke array events
$events = [];
while ($row = mysqli_fetch_assoc($data)) {
    $events[] = [
        "title" => $row['nama_lapangan'] . " (" . $row['nama'] . ")",
        "start" => $row['tanggal'] . "T" . date('H:i:s', strtotime($row['jam_mulai'])),
        "end"   => $row['tanggal'] . "T" . date('H:i:s', strtotime($row['jam_selesai'])),
        "allDay" => false,

        // WARNA BERDASARKAN STATUS
        "backgroundColor" => ($row['status'] == 'approved' ? "#3b82f6" : "#facc15"),

        "borderColor" => ($row['status'] == 'approved' ? "#3b82f6" : "#facc15"),

        "textColor" => "#000", // biar tulisan kelihatan di kuning

        // DATA UNTUK MODAL
        "extendedProps" => [
            "nama" => $row['nama'],
            "lapangan" => $row['nama_lapangan'],
            "status" => $row['status'],
            "jam" => $row['jam_mulai'] . " - " . $row['jam_selesai'],
            "tanggal" => $row['tanggal']
        ]
    ];
}
?>

<style>
    #calendar-month,
    #calendar-week {
        background: #1e293b;
        padding: 15px;
        border-radius: 15px;
        color: white;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }

    .fc-toolbar-title {
        color: white;
    }

    .fc-button {
        background: #f97316 !important;
        border: none !important;
    }

    .fc-button:hover {
        background: #ea580c !important;
    }

    .fc-daygrid-day-number {
        color: #cbd5f5;
    }
</style>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">

<div class="container py-4">

    <h4 class="fw-bold mb-3">📅 Lihat Jadwal Booking</h4>

    <!-- TAB -->
    <ul class="nav nav-tabs justify-content-center mb-3">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#month"><b>Month</b></button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#week"><b>Week</b></button>
        </li>
    </ul>

    <div class="tab-content">

        <!-- MONTH -->
        <div class="tab-pane fade show active" id="month">
            <div id="calendar-month"></div>
        </div>

        <!-- WEEK -->
        <div class="tab-pane fade" id="week">
            <div id="calendar-week"></div>
        </div>

    </div>

</div>

<!-- MODAL DETAIL -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Detail Booking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p><b>Nama:</b> <span id="m_nama"></span></p>
                <p><b>Lapangan:</b> <span id="m_lapangan"></span></p>
                <p><b>Tanggal:</b> <span id="m_tanggal"></span></p>
                <p><b>Jam:</b> <span id="m_jam"></span></p>
                <p><b>Status:</b> <span id="m_status"></span></p>
            </div>

        </div>
    </div>
</div>

<!-- JS FULLCALENDAR (WAJIB DI ATAS SCRIPT KAMU) -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        let events = <?= json_encode($events); ?>;

        // WEEK dulu (biar bisa dipanggil)
        let calendarWeek = new FullCalendar.Calendar(
            document.getElementById('calendar-week'), {
                initialView: 'timeGridWeek',
                events: events,

                slotMinTime: "08:00:00",
                slotMaxTime: "23:00:00",
                slotDuration: "01:00:00",
                height: 650,
                allDaySlot: false,

                eventClick: function(info) {
                    let data = info.event.extendedProps;

                    document.getElementById("m_nama").innerText = data.nama;
                    document.getElementById("m_lapangan").innerText = data.lapangan;
                    document.getElementById("m_tanggal").innerText = data.tanggal;
                    document.getElementById("m_jam").innerText = data.jam;
                    document.getElementById("m_status").innerText = data.status;

                    let modal = new bootstrap.Modal(document.getElementById('detailModal'));
                    modal.show();
                }
            }
        );

        calendarWeek.render();

        // MONTH
        let calendarMonth = new FullCalendar.Calendar(
            document.getElementById('calendar-month'), {
                initialView: 'dayGridMonth',
                events: events,

                dateClick: function(info) {
                    document.querySelector('[data-bs-target="#week"]').click();

                    // arahkan ke tanggal yg diklik
                    calendarWeek.gotoDate(info.dateStr);
                }
            }
        );

        calendarMonth.render();

    });
</script>