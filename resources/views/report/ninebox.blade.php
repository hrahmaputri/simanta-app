@extends('widget/main')
@section('container')
<div class="container">
    <div class="panelcontainer">
        <div class="card-header">
            <table width="100%" cellpadding='3px'>
                <tr>
                    <td width="20%">Jabatan Target</td>
                    <td width="80%">
                        <select id="id_tarjab" name="id_tarjab" class="form-control" />
                        <option value="0">:: Pilih Jabatan Target::</option>
                        @foreach ($target as $jabtarget)
                        <option value="{{$jabtarget['id_target']}}">{{$jabtarget['tanggal']."|".$jabtarget['jabatan']}}</option>
                        @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Kategori Pegawai</td>
                    <td>
                        <select id="id_seleksi" name="id_seleksi" class="form-control" />
                        <option value="0">Semua Pegawai</option>
                        <option value="1">Pegawai sedang menjabat setara eselon target atau eselon diatasnya</option>
                        <option value="2">Pegawai tidak sedang menjabat setara eselon target atau eselon diatasnya</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan='2'>
                        <button type="button" class="btn btn-success" onclick="getData()">Proses</button>
                    </td>
                </tr>
            </table>

        </div>
    </div>
</div>
<div class="container">
    <div class="panelcontainer">
        <div class="bodypanel">
            <table width="100%">
                <tr>
                    <td colspan='3'>
                        <h5> Nine Box Charts</h5>
                    </td>
                </tr>
                <tr>
                    <td width="60%">
                        <div class="bodypanel">
                            <canvas id="myScatter">
                            </canvas>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <script>
        let myChart;

        function getData() {
            var id_target = document.getElementById('id_tarjab');
            var id_seleksi = document.getElementById('id_seleksi');
            $.ajax({
                url: '/dataset',
                method: 'GET',
                dataType: 'json',
                data: 'id_target=' + id_target.value + '&id_seleksi=' + id_seleksi.value,
                success: function(r) {
                    const xValue = r.xValue;
                    const yValue = r.yValue;
                    const lable = r.labels;
                    const total = r.total;

                    if (myChart) {
                        myChart.destroy();
                    }

                    const datum = [];
                    const namlabel = [];
                    for (let i = 0; i < total; i++) {
                        datum.push([xValue[i], yValue[i]]);
                        namlabel.push([lable[i]]);
                    }

                    const data = {
                        labels: namlabel,
                        datasets: [{
                            label: '(Potensial,Kinerja)',
                            data: datum,
                            backgroundColor: [
                                'rgb(29, 27, 28)'
                            ],
                            borderColor: [
                                'rgba(255, 26, 104, 1)'
                            ],
                            borderWidth: 1
                        }]
                    };

                    const ctx = document.getElementById('myScatter');
                    const image = new Image();
                    image.src = 'img/mindy.jpg';

                    const quadrants = {
                        id: 'quadrants',
                        beforeDatasetDraw(chart, args, plugins) {
                            const {
                                ctx,
                                chartArea: {
                                    left,
                                    right,
                                    top,
                                    bottom,
                                    width,
                                    height
                                },
                                scales: {
                                    x,
                                    y
                                }
                            } = chart;

                            const a = left + right;
                            const b = top + bottom;
                            ctx.drawImage(image, a, b);

                            const rangeX = 20;
                            const rangeY = 20;
                            const midX = 60;
                            const midY = 60;


                            const limitX = x.getPixelForValue(rangeX);
                            const limitY = y.getPixelForValue(rangeY);

                            const middleX = x.getPixelForValue(midX);
                            const middleY = y.getPixelForValue(midY);

                            ctx.save();
                            ctx.fillStyle = 'rgba(230, 134, 25, 0.4)';
                            ctx.fillRect(left, top, (right - left) / 3, ((bottom - top) / 3));

                            ctx.fillStyle = 'rgba(27, 225, 40, 0.8)';
                            ctx.fillRect(middleX, top, (right - left) / 3, ((bottom - top) / 3));

                            ctx.fillStyle = 'rgba(12, 129, 12, 0.8)';
                            ctx.fillRect(right + left - middleX, top, (right - left) / 3, ((bottom - top) / 3));

                            ctx.fillStyle = 'rgba(218, 145, 10,0.5)';
                            ctx.fillRect(left, bottom + top - middleY, (right - left) / 3, ((bottom - top) / 3));

                            ctx.fillStyle = 'rgb(217, 236, 9)';
                            ctx.fillRect(middleX, bottom + top - middleY, (right - left) / 3, ((bottom - top) / 3));

                            ctx.fillStyle = 'rgb(14, 129, 222)';
                            ctx.fillRect(right + left - middleX, bottom + top - middleY, (right - left) / 3, ((bottom - top) / 3));

                            ctx.fillStyle = 'rgba(218, 46, 8, 0.5)';
                            ctx.fillRect(left, middleY, (right - left) / 3, ((bottom - top) / 3));

                            ctx.fillStyle = 'rgb(208, 120, 91)';
                            ctx.fillRect(middleX, middleY, (right - left) / 3, ((bottom - top) / 3));

                            ctx.fillStyle = 'rgb(214, 144, 15)';
                            ctx.fillRect(right + left - middleX, middleY, (right - left) / 3, ((bottom - top) / 3));


                            /*ctx.fillStyle = 'rgba(113, 69, 2,0.4)';
                            ctx.fillRect(2 * limitX - left, top, limitX - left, ((bottom - top) / 5));

                            ctx.fillStyle = 'rgba(27, 225, 40, 0.8)';
                            ctx.fillRect(3 * limitX - 2 * left, top, limitX - left, ((bottom - top) / 5));

                            ctx.fillStyle = 'rgba(12, 129, 12, 0.8)';
                            ctx.fillRect(4 * limitX - 3 * left, top, limitX - left, ((bottom - top) / 5));

                            ctx.fillStyle = 'rgba(218, 145, 10,0.5)';
                            ctx.fillRect(2 * limitX - left, middleY, limitX - left, limitY - bottom);

                            ctx.fillStyle = 'rgb(222, 235, 161)';
                            ctx.fillRect(3 * limitX - 2 * left, middleY, limitX - left, limitY - bottom);

                            ctx.fillStyle = 'rgba(116, 113, 211, 0.5)';
                            ctx.fillRect(4 * limitX - 3 * left, middleY, limitX - left, limitY - bottom);


                            ctx.fillStyle = 'rgba(244, 42, 7, 0.6)';
                            ctx.fillRect(2 * limitX - left, 2 * limitY - bottom, limitX - left, limitY - bottom);

                            ctx.fillStyle = 'rgba(218, 145, 10,0.5)';
                            ctx.fillRect(3 * limitX - 2 * left, 2 * limitY - bottom, limitX - left, limitY - bottom);

                            ctx.fillStyle = 'rgba(113, 69, 2,0.4)';
                            ctx.fillRect(4 * limitX - 3 * left, 2 * limitY - bottom, limitX - left, limitY - bottom);
                        */
                        }
                    };

                    myChart = new Chart(ctx, {
                        type: 'scatter',
                        data,
                        options: {
                            scales: {
                                x: {
                                    min: 40,
                                    max: 100,
                                    title: {
                                        display: true,
                                        text: 'Potensial'
                                    }
                                },
                                y: {
                                    min: 40,
                                    max: 100,
                                    title: {
                                        display: true,
                                        text: 'Kinerja'
                                    }
                                },

                            }
                        },
                        plugins: [quadrants],
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
    </script>
</div>

@endsection