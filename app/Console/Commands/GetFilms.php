<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Movie;
use App\Models\Qualification;
use App\Models\Room;
use App\Models\Cinema;
use App\Models\Actor;
use App\Models\Director;
use App\Models\Projection;
use App\Models\Syncronitation;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


class GetFilms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:getFilms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $avenida = 'https://multicinesavenida.reservaentradas.com/multicinesavenida/carteleraxml';

        $ortega = 'https://teatrocinesortega.reservaentradas.com/teatrocinesortega/carteleraxml';


        Qualification::firstOrCreate(array(
            'qualification' => 'No recomendada para menores de 12 años',
            'abbreviation' => '+12',
            'image' => '',
        ));
        Qualification::firstOrCreate(array(
            'qualification' => 'No recomendada para menores de 16 años',
            'abbreviation' => '+16',
            'image' => '',
        ));
        Qualification::firstOrCreate(array(
            'qualification' => 'No recomendada para menores de 18 años',
            'abbreviation' => '+18',
            'image' => '',
        ));
        Qualification::firstOrCreate(array(
            'qualification' => 'No recomendada para menores de 7 años',
            'abbreviation' => '+7',
            'image' => '',
        ));
        Qualification::firstOrCreate(array(
            'qualification' => 'Apta para todos los públicos',
            'abbreviation' => 'TP',
            'image' => '',
        ));
        $sinNada = Qualification::firstOrCreate(array(
            'qualification' => '',
            'abbreviation' => 'PC',
            'image' => '',
        ));
        Qualification::firstOrCreate(array(
            'qualification' => 'Para todos los públicos',
            'abbreviation' => 'TP',
            'image' => '',
        ));
        Room::firstOrCreate(array(
            'room' => 'sala 1',
        ));
        Room::firstOrCreate(array(
            'room' => 'sala 2',
        ));
        Room::firstOrCreate(array(
            'room' => 'sala 3',
        ));
        Room::firstOrCreate(array(
            'room' => 'sala 4',
        ));
        Room::firstOrCreate(array(
            'room' => 'sala 5',
        ));
        Room::firstOrCreate(array(
            'room' => 'sala 6',
        ));
        Room::firstOrCreate(array(
            'room' => 'sala 7',
        ));

        Cinema::firstOrCreate(array(
            'cinema' => 'CINES ORTEGA',
        ));
        Cinema::firstOrCreate(array(
            'cinema' => 'MULTICINES AVENIDA',
        ));
        Cinema::firstOrCreate(array(
            'cinema' => 'TEATRO ORTEGA',
        ));
        Cinema::firstOrCreate(array(
            'cinema' => 'CINE OMY',
        ));

        $syn = Syncronitation::Create(array(
            'result' => 'ok'
        ));

        function URL_exists($Url)
        {
            if (!function_exists('curl_init')) {
                die('CURL is not installed!');
            }
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $Url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec($ch);
            curl_close($ch);
            return $output;
        }
        function RemoveSpecialChar($str)
        {
            $res = preg_replace('/[@\.\+\;\-\:\" "]+/', '', $str);
            return $res;
        }

        function RemoveSpecial($str)
        {
            $res = preg_replace('/Https/', 'https', $str);
            return $res;
        }

        if (@file_get_contents($avenida, true)) {

            $xmlAvenida = @file_get_contents($avenida, true);

            $xmlObject = simplexml_load_string($xmlAvenida);

           // $id=Syncronitation::where('result', 'ok')->orderBy('created_at', 'desc')->first();

           $id=Syncronitation::where('result', 'ok')->orderBy('created_at', 'desc')->skip(1)->first();
           if($id){
               Projection::where( 
                   'syncronitation_id' , $id->id
                                                   )->update(
                   ['syncronitation_id' => $syn->id]
               );
           }
                
            

            

            $cinema_id = Cinema::where('cinema', $xmlObject->recinto['value'])->first();


            //$this->info(print_r($cinema_id->id, true));

            foreach ($xmlObject->recinto->evento as $dato) {
                if (Qualification::where('qualification', $dato->calificacion)->first()) {
                    $qualification = Qualification::where('qualification', $dato->calificacion)->first();
                } else {
                    $qualification = $sinNada;
                }
                if (@URL_exists($dato->caratula)) {
                    if ($dato->titulo) {

                        $imagen2 = file_get_contents($dato->caratula);

                        $photo = Storage::disk('mi_poster')->put(RemoveSpecialChar($dato->titulo) . '_posterAvenida.jpg', $imagen2);

                        // Storage::disk('mi_poster')->allFiles();


                        // $this->info(print_r(  Storage::disk('mi_poster')->allFiles() , true));


                        //$path = asset('images/poster/'.$dato->titulo.'_posterAvenida.jpg');

                        // $this->info(print_r( $file, true));
                        //$headers = array('Accept' => 'application/json');
                        // $query = array('query' => urlencode(rtrim(rtrim( rtrim($movie->titulo, " 3D"), "-VO-" ), " V.O.S.")), 'language' => 'es');
                        $response = Http::get('https://api.themoviedb.org/3/search/movie?api_key=308fcbf28834111e1abaf741ad70b08d&query=' . $dato->titulo . '&language=es');
                        $arrayResponse = $response->json();

                        $result = current($arrayResponse['results']);

                        if ($result) {
                            //$this->info(print_r( $result['id'], true));

                            $response2 = Http::get('https://api.themoviedb.org/3/movie/' . $result['id'] . '?api_key=308fcbf28834111e1abaf741ad70b08d&language=es');
                            $arrayResponse2 = $response2->json();

                            $pathFondo = $arrayResponse2['backdrop_path'];

                            if ($pathFondo) {
                                //$this->info(print_r($pathFondo, true));

                                $fondo = 'https://image.tmdb.org/t/p/original' . $pathFondo;

                                $imagen = file_get_contents($fondo);
                                $imgData = Storage::disk('mi_fondo')->put(RemoveSpecialChar($dato->titulo) . '_fondoAvenida.jpg', $imagen);


                                $this->info(print_r($imgData, true));


                                if ($dato->estreno) {
                                    $date01 = Carbon::parse($dato->estreno);
                                    $date01 = $date01->format('Y-m-d');

                                    //$this->info(print_r( "1".$date01, true));
                                    $mod_date = strtotime($date01 . "+ 7 days");
                                    $dia = date("Y/m/d", $mod_date);
                                    $diaOtro = date("Y/m/d", strtotime($dato->estreno));
                                    if ($diaOtro <= date("Y/m/d")) {
                                        if ($dia >= date("Y/m/d")) {
                                            $estreno = '1';
                                        } else if ($dia < date("Y/m/d")) {
                                            $estreno = null;
                                        }
                                    } else {
                                        if ($dia >= date("Y/m/d")) {
                                            $estreno = null;
                                        } else if ($dia < date("Y/m/d")) {
                                            $estreno = null;
                                        }
                                    }
                                    //$this->info(print_r( "2".$dia, true));

                                    if ($dato->fechas[0]) {
                                        $fechadayid = Carbon::createFromFormat('d/m/Y', $dato->fechas[0]->fecha['value']);
                                        $fechadayid = $fechadayid->format('Y/m/d');

                                        $moviefind1 = Movie::where([
                                            'title' => $dato->titulo,
                                            'buy' => $dato->compra,
                                            'update' => 1,
                                        ])->get();

                                        //$this->info(print_r($moviefind1[0]->title, true));
                                       



                                        if ($moviefind1) {
                                            $moviespan = Movie::where(
                                                [
                                                    'title' => $dato->titulo,
                                                    'buy' => $dato->compra,
                                                    'update' => 1,
                                                ]
                                            )->get()->first();
                                            $movie = $moviespan;
                                            
                                        }


                                        if (!$movie) {
                                            $movie1 = Movie::updateOrCreate(
                                                [
                                                    'buy' => $dato->compra,
                                                    'update' => 0,
                                                ],
                                                array(
                                                    'title' => $dato->titulo,
                                                    'synopsis' => $dato->sinopsis,
                                                    'duration' => $dato->duracion,


                                                    'date' => $fechadayid,
                                                    'trailer' => $dato->trailer,
                                                    'type' => $dato->tipodecontenido,
                                                    'premiere' => $date01,
                                                    'buy' => $dato->compra,
                                                    'active' => $estreno,
                                                    'qualification_id' => $qualification->id,
                                                    'update' => 0,
                                                )
                                            );
                                            $movie1->clearMediaCollection('posters');


                                            $movie1->clearMediaCollection('backgrounds');
                                            if ($movie1) {

                                                $movie1->clearMediaCollection('posters');


                                                $movie1->clearMediaCollection('backgrounds');


                                                $movie1->addMediaFromUrl(RemoveSpecial($dato->caratula))->toMediaCollection('posters');
                                                $movie1->addMediaFromUrl('https://image.tmdb.org/t/p/original' . $pathFondo)->toMediaCollection('backgrounds');
                                                $movie = $movie1;
                                            }
                                        }
                                        $this->info(print_r($dato->fechas[0]->fecha['value'], true));

                                        foreach ($dato->fechas->fecha as $fecha) {
                                            $fechita = Carbon::createFromFormat('d/m/Y', $fecha['value']);
                                            $dia01 = date("d/m/Y", strtotime($fechita));
                                            if ($dia01 == date("d/m/Y")) {
                                                foreach ($fecha->sesiones->sesion as $sesion) {

                                                    $time = time();
                                                    $hora = date("H:i", $time);
                                                    $fechaday = Carbon::createFromFormat('d/m/Y', $fecha['value']);
                                                    $fechaday = $fechaday->format('Y-m-d');

                                                    $this->info(print_r($sesion['hora'], true));
                                                    $this->info(print_r($hora, true));

                                                    Projection::updateOrCreate(array(
                                                        'hour' => $sesion['hora'],
                                                        'movie_id' => $movie->id,
                                                        'room_id' => $sesion['sala'],
                                                        'cinema_id' => $cinema_id->id,
                                                        'syncronitation_id' => $syn->id,
                                                    ));
                                                }
                                            }
                                        }
                                    }
                                }
                            } else {
                                if ($dato->estreno) {
                                    $date2 = Carbon::parse($dato->estreno);
                                    $date2 = $date2->format('Y-m-d');

                                    $mod_date = strtotime($date2 . "+ 7 days");
                                    $dia = date("Y/m/d", $mod_date);
                                    $diaOtro = date("Y/m/d", strtotime($date2));
                                    if ($diaOtro <= date("Y/m/d")) {
                                        if ($dia >= date("Y/m/d")) {
                                            $estreno = '1';
                                        } else if ($dia < date("Y/m/d")) {
                                            $estreno = null;
                                        }
                                    } else {
                                        if ($dia >= date("Y/m/d")) {
                                            $estreno = null;
                                        } else if ($dia < date("Y/m/d")) {
                                            $estreno = null;
                                        }
                                    }
                                    if ($dato->fechas[0]) {
                                        $fechadayid2 = Carbon::createFromFormat('d/m/Y', $dato->fechas[0]->fecha['value']);
                                        $fechadayid2 = $fechadayid2->format('Y/m/d');
                                        $moviefind2 = Movie::where([
                                            'title' => $dato->titulo,
                                            'buy' => $dato->compra,
                                            'update' => 1,
                                        ])->get();


                                        if ($moviefind2) {
                                            $moviespan2 = Movie::where(
                                                [
                                                    'title' => $dato->titulo,
                                                    'buy' => $dato->compra,
                                                    'update' => 1,
                                                ]
                                            )->get()->first();
                                            $movie = $moviespan2;
                                        }

                                        if (!$movie) {
                                            $movie2 = Movie::updateOrCreate(
                                                [
                                                    'buy' => $dato->compra,
                                                    'update' => 0,
                                                ],
                                                array(
                                                    'title' => $dato->titulo,
                                                    'synopsis' => $dato->sinopsis,
                                                    'duration' => $dato->duracion,

                                                    'date' =>  $fechadayid2,
                                                    'trailer' => $dato->trailer,
                                                    'type' => $dato->tipodecontenido,
                                                    'premiere' => $date2,
                                                    'buy' => $dato->compra,
                                                    'active' => $estreno,
                                                    'qualification_id' => $qualification->id,
                                                    'update' => 0,
                                                )
                                            );
                                            $movie2->clearMediaCollection('posters');
                                            if ($movie2) {

                                                $movie2->clearMediaCollection('posters');



                                                $movie2->addMediaFromUrl(RemoveSpecial($dato->caratula))->toMediaCollection('posters');

                                                $movie = $movie2;
                                            }
                                        }



                                        $this->info(print_r($dato->fechas[0]->fecha['value'], true));

                                        foreach ($dato->fechas->fecha as $fecha) {
                                            $fechita2 = Carbon::createFromFormat('d/m/Y', $fecha['value']);
                                            $dia2 = date("d/m/Y", strtotime($fechita2));

                                            if ($dia2 == date("d/m/Y")) {
                                                foreach ($fecha->sesiones->sesion as $sesion) {
                                                    $fechaday = Carbon::createFromFormat('d/m/Y', $fecha['value']);
                                                    $fechaday = $fechaday->format('Y-m-d');
                                                    $time = time();
                                                    $hora = date("H:i", $time);


                                                    Projection::updateOrCreate(array(
                                                        'hour' => $sesion['hora'],

                                                        'movie_id' => $movie->id,
                                                        'room_id' => $sesion['sala'],
                                                        'cinema_id' => $cinema_id->id,
                                                        'syncronitation_id' => $syn->id,
                                                    ));
                                                }
                                            }
                                        }
                                    }
                                }
                            }

                            $response3 = Http::get('https://api.themoviedb.org/3/movie/' . $result['id'] . '/credits?api_key=308fcbf28834111e1abaf741ad70b08d&language=es');
                            $arrayResponse3 = $response3->json();

                            $cast = $arrayResponse3['cast'];
                            $crew = $arrayResponse3['crew'];


                            if ($cast) {
                                $movie->actors()->detach();
                                foreach ($cast as $actor) {
                                    if ($actor['known_for_department'] == 'Acting') {

                                        $arrayActor = Actor::updateOrCreate(array(
                                            'actor' => $actor['name'],

                                        ));

                                        $movie->actors()->attach($arrayActor->id);
                                    }
                                }
                            }

                            if ($crew) {
                                $movie->directors()->detach();
                                foreach ($crew as $director) {
                                    if ($director['job'] == 'Director') {
                                        $arrayDirector = Director::updateOrCreate(array(
                                            'director' => $director['name'],
                                        ));

                                        $movie->directors()->attach($arrayDirector->id);
                                    }
                                }
                            }
                        } else {
                            if ($dato->estreno) {
                                $date3 = Carbon::parse($dato->estreno);
                                $date3 = $date3->format('Y-m-d');
                                $mod_date = strtotime($date3 . "+ 7 days");
                                $dia = date("Y/m/d", $mod_date);
                                $diaOtro = date("Y/m/d", strtotime($dato->estreno));
                                if ($diaOtro <= date("Y/m/d")) {
                                    if ($dia >= date("Y/m/d")) {
                                        $estreno = '1';
                                    } else if ($dia < date("Y/m/d")) {
                                        $estreno = null;
                                    }
                                } else {
                                    if ($dia >= date("Y/m/d")) {
                                        $estreno = null;
                                    } else if ($dia < date("Y/m/d")) {
                                        $estreno = null;
                                    }
                                }
                                if ($dato->fechas[0]) {
                                    $fechadayid3 = Carbon::createFromFormat('d/m/Y', $dato->fechas[0]->fecha['value']);
                                    $fechadayid3 = $fechadayid3->format('Y/m/d');
                                    $moviefind3 = Movie::where([
                                        'title' => $dato->titulo,
                                        'buy' => $dato->compra,
                                        'update' => 1,
                                    ])->get();



                                    if ($moviefind3) {
                                        $moviespan3 = Movie::where(
                                            [
                                                'title' => $dato->titulo,
                                                'buy' => $dato->compra,
                                                'update' => 1,
                                            ]
                                        )->get()->first();
                                        $movie = $moviespan3;
                                    }

                                    if (!$movie) {
                                        $movie3 = Movie::updateOrCreate(
                                            [
                                                'buy' => $dato->compra,
                                                'update' => 0,
                                            ],
                                            array(
                                                'title' => $dato->titulo,
                                                'synopsis' => $dato->sinopsis,
                                                'duration' => $dato->duracion,

                                                'date' => $fechadayid3,
                                                'trailer' => $dato->trailer,

                                                'type' => $dato->tipodecontenido,
                                                'premiere' => $date3,
                                                'buy' => $dato->compra,
                                                'active' => $estreno,
                                                'qualification_id' => $qualification->id,
                                                'update' => 0,
                                            )
                                        );
                                        $movie3->clearMediaCollection('posters');
                                        if ($movie3) {

                                            $movie3->clearMediaCollection('posters');


                                            $movie3->addMediaFromUrl(RemoveSpecial($dato->caratula))->toMediaCollection('posters');

                                            $movie = $movie3;
                                        }
                                    }

                                    $this->info(print_r($dato->fechas[0]->fecha['value'], true));

                                    foreach ($dato->fechas->fecha as $fecha) {
                                        $fechita3 = Carbon::createFromFormat('d/m/Y', $fecha['value']);
                                        $dia3 = date("d/m/Y", strtotime($fechita3));
                                        if ($dia3 == date("d/m/Y")) {
                                            foreach ($fecha->sesiones->sesion as $sesion) {
                                                $fechaday = Carbon::createFromFormat('d/m/Y', $fecha['value']);
                                                $fechaday = $fechaday->format('Y-m-d');
                                                $time = time();
                                                $hora = date("H:i", $time);


                                                Projection::updateOrCreate(array(
                                                    'hour' => $sesion['hora'],

                                                    'movie_id' => $movie->id,
                                                    'room_id' => $sesion['sala'],
                                                    'cinema_id' => $cinema_id->id,
                                                    'syncronitation_id' => $syn->id,
                                                ));
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }


            foreach ($xmlObject->ProximosEventos->evento as $dato) {


                if (Qualification::where('qualification', $dato->calificacion)->first()) {
                    $qualification = Qualification::where('qualification', $dato->calificacion)->first();
                } else {
                    $qualification = $sinNada;
                }
                if (@URL_exists($dato->caratula)) {
                    if ($dato->titulo) {
                        $imagen2 = file_get_contents($dato->caratula);
                        Storage::disk('mi_poster')->put($dato->titulo . '_posterAvenida.jpg', $imagen2);

                        //$headers = array('Accept' => 'application/json');
                        // $query = array('query' => urlencode(rtrim(rtrim( rtrim($movie->titulo, " 3D"), "-VO-" ), " V.O.S.")), 'language' => 'es');
                        $response = Http::get('https://api.themoviedb.org/3/search/movie?api_key=308fcbf28834111e1abaf741ad70b08d&query=' . $dato->titulo . '&language=es');
                        $arrayResponse = $response->json();

                        $result = current($arrayResponse['results']);

                        if ($result) {
                            //$this->info(print_r( $result['id'], true));

                            $response2 = Http::get('https://api.themoviedb.org/3/movie/' . $result['id'] . '?api_key=308fcbf28834111e1abaf741ad70b08d&language=es');
                            $arrayResponse2 = $response2->json();

                            $pathFondo = $arrayResponse2['backdrop_path'];

                            if ($pathFondo) {
                                // $this->info(print_r($pathFondo, true));

                                $fondo = 'https://image.tmdb.org/t/p/original' . $pathFondo;

                                $imagen = file_get_contents($fondo);
                                Storage::disk('mi_fondo')->put(RemoveSpecialChar($dato->titulo) . '_fondoAvenida.jpg', $imagen);

                                if ($dato->estreno) {
                                    $date4 = Carbon::parse($dato->estreno);
                                    $date4 = $date4->format('Y-m-d');
                                    $mod_date = strtotime($date4 . "+ 7 days");
                                    $dia = date("Y/m/d", $mod_date);
                                    $diaOtro = date("Y/m/d", strtotime($dato->estreno));
                                    if ($diaOtro <= date("Y/m/d")) {
                                        if ($dia >= date("Y/m/d")) {
                                            $estreno = '1';
                                        } else if ($dia < date("Y/m/d")) {
                                            $estreno = null;
                                        }
                                    } else {
                                        if ($dia >= date("Y/m/d")) {
                                            $estreno = null;
                                        } else if ($dia < date("Y/m/d")) {
                                            $estreno = null;
                                        }
                                    }

                                    if ($dato->fechas[0]) {
                                        $fechadayid4 = Carbon::createFromFormat('d/m/Y', $dato->fechas[0]->fecha['value']);
                                        $fechadayid4 = $fechadayid4->format('Y/m/d');
                                        $moviefind4 = Movie::where([
                                            'title' => $dato->titulo,
                                            'buy' => $dato->compra,
                                            'update' => 1,
                                        ])->get();



                                        if ($moviefind4) {
                                            $moviespan4 = Movie::where(
                                                [
                                                    'title' => $dato->titulo,
                                                    'buy' => $dato->compra,
                                                    'update' => 1,
                                                ]
                                            )->get()->first();
                                            $movie = $moviespan4;
                                        }

                                        if (!$movie) {
                                            $movie4 = Movie::updateOrCreate(
                                                [
                                                    'buy' => $dato->compra,
                                                ],
                                                array(
                                                    'title' => $dato->titulo,
                                                    'synopsis' => $dato->sinopsis,
                                                    'duration' => $dato->duracion,


                                                    'date' => $fechadayid4,
                                                    'trailer' => $dato->trailer,

                                                    'type' => $dato->tipodecontenido,

                                                    'premiere' => $date4,
                                                    'buy' => $dato->compra,
                                                    'active' => $estreno,
                                                    'qualification_id' => $qualification->id,
                                                    'update' => 0,
                                                )
                                            );

                                            $movie4->clearMediaCollection('posters');


                                            $movie4->clearMediaCollection('backgrounds');
                                            if ($movie4) {

                                                $movie4->clearMediaCollection('posters');


                                                $movie4->clearMediaCollection('backgrounds');

                                                $movie4->addMediaFromUrl(RemoveSpecial($dato->caratula))->toMediaCollection('posters');
                                                $movie4->addMediaFromUrl('https://image.tmdb.org/t/p/original' . $pathFondo)->toMediaCollection('backgrounds');
                                                $movie = $movie4;
                                            }
                                        }


                                        $this->info(print_r($dato->fechas[0]->fecha['value'], true));

                                        foreach ($dato->fechas as $fecha) {
                                            foreach ($fecha->fecha->sesiones->sesion as $sesion) {
                                                $fechaday = Carbon::createFromFormat('d/m/Y', $fecha->fecha['value']);
                                                $fechaday = $fechaday->format('d/m/Y');
                                                Projection::updateOrCreate(array(
                                                    'hour' => $sesion['hora'],
                                                    'release_date' => $fechaday,
                                                    'movie_id' => $movie->id,
                                                    'room_id' => $sesion['sala'],
                                                    'cinema_id' => $cinema_id->id,
                                                    'syncronitation_id' => $syn->id,
                                                ));
                                            }
                                        }
                                    }
                                }
                            } else {
                                if ($dato->estreno) {
                                    $date5 = Carbon::parse($dato->estreno);
                                    $date5 = $date5->format('Y-m-d');
                                    $mod_date = strtotime($date5 . "+ 7 days");
                                    $dia = date("Y/m/d", $mod_date);
                                    //$this->info(print_r( "1".$date5, true));
                                    //$this->info(print_r( "2".$dia, true));
                                    $diaOtro = date("Y/m/d", strtotime($dato->estreno));
                                    if ($diaOtro <= date("Y/m/d")) {
                                        if ($dia >= date("Y/m/d")) {
                                            $estreno = '1';
                                        } else if ($dia < date("Y/m/d")) {
                                            $estreno = null;
                                        }
                                    } else {
                                        if ($dia >= date("Y/m/d")) {
                                            $estreno = null;
                                        } else if ($dia < date("Y/m/d")) {
                                            $estreno = null;
                                        }
                                    }
                                    if ($dato->fechas[0]) {
                                        $fechadayid5 = Carbon::createFromFormat('d/m/Y', $dato->fechas[0]->fecha['value']);
                                        $fechadayid5 = $fechadayid5->format('Y/m/d');
                                        $moviefind6 = Movie::where([
                                            'title' => $dato->titulo,
                                            'buy' => $dato->compra,
                                            'update' => 1,
                                        ])->get();



                                        if ($moviefind6) {
                                            $moviespan6 = Movie::where(
                                                [
                                                    'title' => $dato->titulo,
                                                    'buy' => $dato->compra,
                                                    'update' => 1,
                                                ]
                                            )->get()->first();
                                            $movie = $moviespan6;
                                        }

                                        if (!$movie) {
                                            $movie5 = Movie::updateOrCreate(
                                                [
                                                    'buy' => $dato->compra,
                                                    'update' => 0,
                                                ],
                                                array(
                                                    'title' => $dato->titulo,
                                                    'synopsis' => $dato->sinopsis,
                                                    'duration' => $dato->duracion,

                                                    'trailer' => $dato->trailer,
                                                    'qualification_id' => $qualification->id,
                                                    'type' => $dato->tipodecontenido,
                                                    'premiere' => $date5,
                                                    'buy' => $dato->compra,
                                                    'active' => $estreno,
                                                    'date' => $fechadayid5,
                                                    'update' => 0,
                                                )
                                            );
                                            $movie5->clearMediaCollection('posters');
                                            if ($movie5) {

                                                $movie5->clearMediaCollection('posters');


                                                $movie5->addMediaFromUrl(RemoveSpecial($dato->caratula))->toMediaCollection('posters');
                                                $movie = $movie5;
                                            }
                                        }



                                        $this->info(print_r($dato->fechas[0]->fecha['value'], true));


                                        foreach ($dato->fechas as $fecha) {

                                            foreach ($fecha->fecha->sesiones->sesion as $sesion) {
                                                $fechaday1 = Carbon::createFromFormat('d/m/Y', $fecha->fecha['value']);
                                                $fechaday1 = $fechaday1->format('d/m/Y');
                                                Projection::updateOrCreate(array(
                                                    'hour' => $sesion['hora'],
                                                    'release_date' => $fechaday1,
                                                    'movie_id' => $movie->id,
                                                    'room_id' => $sesion['sala'],
                                                    'cinema_id' => $cinema_id->id,
                                                    'syncronitation_id' => $syn->id,
                                                ));
                                            }
                                        }
                                    }
                                }
                            }

                            $response3 = Http::get('https://api.themoviedb.org/3/movie/' . $result['id'] . '/credits?api_key=308fcbf28834111e1abaf741ad70b08d&language=es');
                            $arrayResponse3 = $response3->json();

                            $cast = $arrayResponse3['cast'];
                            $crew = $arrayResponse3['crew'];


                            if ($cast) {
                                $movie->actors()->detach();
                                foreach ($cast as $actor) {
                                    if ($actor['known_for_department'] == 'Acting') {

                                        $arrayActor = Actor::updateOrCreate(array(
                                            'actor' => $actor['name'],

                                        ));

                                        $movie->actors()->attach($arrayActor->id);
                                    }
                                }
                            }

                            if ($crew) {
                                $movie->directors()->detach();
                                foreach ($crew as $director) {
                                    if ($director['job'] == 'Director') {
                                        $arrayDirector = Director::updateOrCreate(array(
                                            'director' => $director['name'],
                                        ));

                                        $movie->directors()->attach($arrayDirector->id);
                                    }
                                }
                            }
                        } else {
                            if ($dato->estreno) {
                                $date6 = Carbon::parse($dato->estreno);
                                $date6 = $date6->format('Y-m-d');
                                $mod_date = strtotime($date6 . "+ 7 days");
                                $dia = date("Y/m/d", $mod_date);
                                //$this->info(print_r( "1".$date6, true));
                                //$this->info(print_r( "2".$dia, true));
                                $diaOtro = date("Y/m/d", strtotime($dato->estreno));
                                if ($diaOtro <= date("Y/m/d")) {
                                    if ($dia >= date("Y/m/d")) {
                                        $estreno = '1';
                                    } else if ($dia < date("Y/m/d")) {
                                        $estreno = null;
                                    }
                                } else {
                                    if ($dia >= date("Y/m/d")) {
                                        $estreno = null;
                                    } else if ($dia < date("Y/m/d")) {
                                        $estreno = null;
                                    }
                                }
                                if ($dato->fechas[0]) {
                                    $fechadayid6 = Carbon::createFromFormat('d/m/Y', $dato->fechas[0]->fecha['value']);
                                    $fechadayid6 = $fechadayid6->format('Y/m/d');

                                    $moviefind7 = Movie::where([
                                        'title' => $dato->titulo,
                                        'buy' => $dato->compra,
                                        'update' => 1,
                                    ])->get();


                                    if ($moviefind7) {
                                        $moviespan7 = Movie::where(
                                            [
                                                'title' => $dato->titulo,
                                                'buy' => $dato->compra,
                                                'update' => 1,
                                            ]
                                        )->get()->first();
                                        $movie = $moviespan7;
                                    }

                                    if (!$movie) {
                                        $movie6 = Movie::updateOrCreate(
                                            [
                                                'buy' => $dato->compra,
                                                'update' => 0,
                                            ],
                                            array(
                                                'title' => $dato->titulo,
                                                'synopsis' => $dato->sinopsis,
                                                'duration' => $dato->duracion,

                                                'trailer' => $dato->trailer,
                                                'qualification_id' => $qualification->id,
                                                'type' => $dato->tipodecontenido,
                                                'premiere' => $date6,
                                                'buy' => $dato->compra,
                                                'active' => $estreno,
                                                'date' => $fechadayid6,
                                                'update' => 0,
                                            )
                                        );
                                        $movie6->clearMediaCollection('posters');
                                        if ($movie6) {

                                            $movie6->clearMediaCollection('posters');


                                            $movie6->addMediaFromUrl(RemoveSpecial($dato->caratula))->toMediaCollection('posters');
                                            $movie = $movie6;
                                        }
                                    }


                                    $this->info(print_r($dato->fechas[0]->fecha['value'], true));


                                    foreach ($dato->fechas as $fecha) {
                                        foreach ($fecha->fecha->sesiones->sesion as $sesion) {
                                            $fechaday2 = Carbon::createFromFormat('d/m/Y', $fecha->fecha['value']);
                                            $fechaday2 = $fechaday2->format('d/m/Y');
                                            Projection::updateOrCreate(array(
                                                'hour' => $sesion['hora'],
                                                'release_date' => $fechaday2,
                                                'movie_id' => $movie->id,
                                                'room_id' => $sesion['sala'],
                                                'cinema_id' => $cinema_id->id,
                                                'syncronitation_id' => $syn->id,
                                            ));
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $this->info(print_r('no esta disponible el cine avenida', true));
        }

        if (@file_get_contents($ortega, true)) {

            $xmlOrtega = @file_get_contents($ortega, true);
            $xmlObject = simplexml_load_string($xmlOrtega);
            $id=Syncronitation::where('result', 'ok')->orderBy('created_at', 'desc')->skip(1)->first();
            if($id){
                Projection::where( 
                    'syncronitation_id' , $id->id
                                                    )->update(
                    ['syncronitation_id' => $syn->id]
                );
            }
            
           

            foreach ($xmlObject->recinto->evento as $dato) {
                if ($dato->titulo['nexp'] == 0) {
                    //$this->info(print_r($dato->titulo['nexp'], true));
                    $cinema_id = 3;
                } else {
                    //$this->info(print_r($dato->titulo['nexp'], true));
                    $cinema_id = 1;
                }
                if (Qualification::where('qualification', $dato->calificacion)->first()) {
                    $qualification = Qualification::where('qualification', $dato->calificacion)->first();
                } else {
                    $qualification = $sinNada;
                }
                if (@URL_exists($dato->caratula)) {
                    if ($dato->titulo) {
                        $imagen2 = file_get_contents($dato->caratula);
                        Storage::disk('mi_poster')->put(RemoveSpecialChar($dato->titulo) . '_posterOrtega.jpg', $imagen2);

                        //$headers = array('Accept' => 'application/json');
                        // $query = array('query' => urlencode(rtrim(rtrim( rtrim($movie->titulo, " 3D"), "-VO-" ), " V.O.S.")), 'language' => 'es');
                        $response = Http::get('https://api.themoviedb.org/3/search/movie?api_key=308fcbf28834111e1abaf741ad70b08d&query=' . $dato->titulo . '&language=es');
                        $arrayResponse = $response->json();

                        $result = current($arrayResponse['results']);

                        if ($result) {
                            //$this->info(print_r( $result['id'], true));

                            $response2 = Http::get('https://api.themoviedb.org/3/movie/' . $result['id'] . '?api_key=308fcbf28834111e1abaf741ad70b08d&language=es');
                            $arrayResponse2 = $response2->json();

                            $pathFondo = $arrayResponse2['backdrop_path'];

                            if ($pathFondo) {
                                //$this->info(print_r($pathFondo, true));

                                $fondo = 'https://image.tmdb.org/t/p/original' . $pathFondo;

                                $imagen = file_get_contents($fondo);
                                Storage::disk('mi_fondo')->put(RemoveSpecialChar($dato->titulo) . '_fondoOrtega.jpg', $imagen);

                                if ($dato->estreno) {
                                    $date7 = Carbon::parse($dato->estreno);
                                    $date7 = $date7->format('Y-m-d');
                                    $mod_date = strtotime($date7 . "+ 7 days");
                                    $dia = date("Y/m/d", $mod_date);
                                    // $this->info(print_r( "1".$date7, true));
                                    // $this->info(print_r( "2".$dia, true));
                                    $diaOtro = date("Y/m/d", strtotime($dato->estreno));
                                    if ($diaOtro <= date("Y/m/d")) {
                                        if ($dia >= date("Y/m/d")) {
                                            $estreno = '1';
                                        } else if ($dia < date("Y/m/d")) {
                                            $estreno = null;
                                        }
                                    } else {
                                        if ($dia >= date("Y/m/d")) {
                                            $estreno = null;
                                        } else if ($dia < date("Y/m/d")) {
                                            $estreno = null;
                                        }
                                    }
                                    if ($dato->fechas[0]) {
                                        $fechadayid7 = Carbon::createFromFormat('d/m/Y', $dato->fechas[0]->fecha['value']);
                                        $fechadayid7 = $fechadayid7->format('Y/m/d');
                                        $moviefind8 = Movie::where([
                                            'title' => $dato->titulo,
                                            'buy' => $dato->compra,
                                            'update' => 1,
                                        ])->get();


                                        if ($moviefind8) {
                                            $moviespan8 = Movie::where(
                                                [
                                                    'title' => $dato->titulo,
                                                    'buy' => $dato->compra,
                                                    'update' => 1,
                                                ]
                                            )->get()->first();
                                            $movie22 = $moviespan8;
                                        }

                                        if (!$movie22) {
                                            $movie7 = Movie::updateOrCreate(
                                                [
                                                    'buy' => $dato->compra,
                                                    'update' => 0,
                                                ],
                                                array(
                                                    'title' => $dato->titulo,
                                                    'synopsis' => $dato->sinopsis,
                                                    'duration' => $dato->duracion,

                                                    'trailer' => $dato->trailer,
                                                    'qualification_id' => $qualification->id,
                                                    'type' => $dato->tipodecontenido,

                                                    'premiere' => $date7,
                                                    'buy' => $dato->compra,
                                                    'active' => $estreno,
                                                    'date' => $fechadayid7,
                                                    'update' => 0,
                                                )
                                            );
                                            $movie7->clearMediaCollection('posters');


                                            $movie7->clearMediaCollection('backgrounds');
                                            if ($movie7) {

                                                $movie7->clearMediaCollection('posters');


                                                $movie7->clearMediaCollection('backgrounds');

                                                $movie7->addMediaFromUrl(RemoveSpecial($dato->caratula))->toMediaCollection('posters');
                                                $movie7->addMediaFromUrl('https://image.tmdb.org/t/p/original' . $pathFondo)->toMediaCollection('backgrounds');
                                                $movie22 = $movie7;
                                            }
                                        }


                                        $this->info(print_r($dato->fechas[0]->fecha['value'], true));
                                        foreach ($dato->fechas->fecha as $fecha) {
                                            $fechita4 = Carbon::createFromFormat('d/m/Y', $fecha['value']);
                                            $dia4 = date("d/m/Y", strtotime($fechita4));
                                            if ($dia4 == date("d/m/Y")) {
                                                foreach ($fecha->sesiones->sesion as $sesion) {

                                                    $time = time();
                                                    $hora = date("H:i", $time);
                                                    $fechaday = Carbon::createFromFormat('d/m/Y', $fecha['value']);
                                                    $fechaday = $fechaday->format('Y-m-d');

                                                    Projection::updateOrCreate(array(
                                                        'hour' => $sesion['hora'],

                                                        'movie_id' => $movie22->id,
                                                        'room_id' => $sesion['sala'],
                                                        'cinema_id' => $cinema_id,
                                                        'syncronitation_id' => $syn->id,
                                                    ));
                                                }
                                            }
                                        }
                                    }
                                }
                            } else {
                                if ($dato->estreno) {
                                    $date8 = Carbon::parse($dato->estreno);
                                    $date8 = $date8->format('Y-m-d');
                                    $mod_date = strtotime($date8 . "+ 7 days");
                                    $dia = date("Y/m/d", $mod_date);
                                    //$this->info(print_r( "1".$date8, true));
                                    //$this->info(print_r( "2".$dia, true));
                                    $diaOtro = date("Y/m/d", strtotime($dato->estreno));
                                    if ($diaOtro <= date("Y/m/d")) {
                                        if ($dia >= date("Y/m/d")) {
                                            $estreno = '1';
                                        } else if ($dia < date("Y/m/d")) {
                                            $estreno = null;
                                        }
                                    } else {
                                        if ($dia >= date("Y/m/d")) {
                                            $estreno = null;
                                        } else if ($dia < date("Y/m/d")) {
                                            $estreno = null;
                                        }
                                    }
                                    if ($dato->fechas[0]) {
                                        $fechadayid8 = Carbon::createFromFormat('d/m/Y', $dato->fechas[0]->fecha['value']);
                                        $fechadayid8 = $fechadayid8->format('Y/m/d');
                                        $moviefind9 = Movie::where([
                                            'title' => $dato->titulo,
                                            'buy' => $dato->compra,
                                            'update' => 1,
                                        ])->get();

                                        if ($moviefind9) {
                                            $moviespan9 = Movie::where(
                                                [
                                                    'title' => $dato->titulo,
                                                    'buy' => $dato->compra,
                                                    'update' => 1,
                                                ]
                                            )->get()->first();
                                            $movie22 = $moviespan9;
                                        }

                                        if (!$movie22) {
                                            $movie8 = Movie::updateOrCreate(
                                                [
                                                    'buy' => $dato->compra,
                                                    'update' => 0,
                                                ],
                                                array(
                                                    'title' => $dato->titulo,
                                                    'synopsis' => $dato->sinopsis,
                                                    'duration' => $dato->duracion,

                                                    'trailer' => $dato->trailer,
                                                    'qualification_id' => $qualification->id,
                                                    'type' => $dato->tipodecontenido,
                                                    'premiere' => $date8,
                                                    'buy' => $dato->compra,
                                                    'active' => $estreno,
                                                    'date' => $fechadayid8,
                                                    'update' => 0,
                                                )
                                            );
                                            $movie8->clearMediaCollection('posters');
                                            if ($movie8) {

                                                $movie8->clearMediaCollection('posters');


                                                $movie8->addMediaFromUrl(RemoveSpecial($dato->caratula))->toMediaCollection('posters');

                                                $movie22 = $movie8;
                                            }
                                        }

                                        $this->info(print_r($dato->fechas[0]->fecha['value'], true));


                                        foreach ($dato->fechas->fecha as $fecha) {
                                            $fechita5 = Carbon::createFromFormat('d/m/Y', $fecha['value']);
                                            $dia5 = date("d/m/Y", strtotime($fechita5));
                                            if ($dia5 == date("d/m/Y")) {
                                                foreach ($fecha->sesiones->sesion as $sesion) {

                                                    $time = time();
                                                    $hora = date("H:i", $time);
                                                    $fechaday = Carbon::createFromFormat('d/m/Y', $fecha['value']);
                                                    $fechaday = $fechaday->format('Y-m-d');

                                                    Projection::updateOrCreate(array(
                                                        'hour' => $sesion['hora'],

                                                        'movie_id' => $movie22->id,
                                                        'room_id' => $sesion['sala'],
                                                        'cinema_id' => $cinema_id,
                                                        'syncronitation_id' => $syn->id,
                                                    ));
                                                }
                                            }
                                        }
                                    }
                                }
                            }

                            $response3 = Http::get('https://api.themoviedb.org/3/movie/' . $result['id'] . '/credits?api_key=308fcbf28834111e1abaf741ad70b08d&language=es');
                            $arrayResponse3 = $response3->json();

                            $cast = $arrayResponse3['cast'];
                            $crew = $arrayResponse3['crew'];


                            if ($cast) {
                                $movie22->actors()->detach();
                                foreach ($cast as $actor) {
                                    if ($actor['known_for_department'] == 'Acting') {
                                        $arrayActor2 = Actor::updateOrCreate(array(
                                            'actor' => $actor['name'],

                                        ));

                                        $movie22->actors()->attach($arrayActor2->id);
                                    }
                                }
                            }

                            if ($crew) {
                                $movie22->directors()->detach();
                                foreach ($crew as $director) {
                                    if ($director['job'] == 'Director') {
                                        $arrayDirector2 = Director::updateOrCreate(array(
                                            'director' => $director['name'],
                                        ));

                                        $movie22->directors()->attach($arrayDirector2->id);
                                    }
                                }
                            }
                        } else {
                            if ($dato->estreno) {
                                $date9 = Carbon::parse($dato->estreno);
                                $date9 = $date9->format('Y-m-d');
                                $mod_date = strtotime($date9 . "+ 7 days");
                                $dia = date("Y/m/d", $mod_date);
                                //$this->info(print_r( "1".$date9, true));
                                //$this->info(print_r( "2".$dia, true));
                                $diaOtro = date("Y/m/d", strtotime($dato->estreno));
                                if ($diaOtro <= date("Y/m/d")) {
                                    if ($dia >= date("Y/m/d")) {
                                        $estreno = '1';
                                    } else if ($dia < date("Y/m/d")) {
                                        $estreno = null;
                                    }
                                } else {
                                    if ($dia >= date("Y/m/d")) {
                                        $estreno = null;
                                    } else if ($dia < date("Y/m/d")) {
                                        $estreno = null;
                                    }
                                }
                                if ($dato->fechas[0]) {
                                    $fechadayid9 = Carbon::createFromFormat('d/m/Y', $dato->fechas[0]->fecha['value']);
                                    $fechadayid9 = $fechadayid9->format('Y/m/d');
                                    $moviefind10 = Movie::where([
                                        'title' => $dato->titulo,
                                        'buy' => $dato->compra,
                                        'update' => 1,
                                    ])->get();


                                    if ($moviefind10) {
                                        $moviespan10 = Movie::where(
                                            [
                                                'title' => $dato->titulo,
                                                'buy' => $dato->compra,
                                                'update' => 1,
                                            ]
                                        )->get()->first();
                                        $movie22 = $moviespan10;
                                    }

                                    if (!$movie22) {
                                        $movie9 = Movie::updateOrCreate(
                                            [
                                                'buy' => $dato->compra,
                                                'update' => 0,
                                            ],
                                            array(
                                                'title' => $dato->titulo,
                                                'synopsis' => $dato->sinopsis,
                                                'duration' => $dato->duracion,

                                                'trailer' => $dato->trailer,
                                                'qualification_id' => $qualification->id,
                                                'type' => $dato->tipodecontenido,
                                                'premiere' => $date9,
                                                'buy' => $dato->compra,
                                                'active' => $estreno,
                                                'date' => $fechadayid9,
                                                'update' => 0,
                                            )
                                        );
                                        $movie9->clearMediaCollection('posters');
                                        if ($movie9) {

                                            $movie9->clearMediaCollection('posters');


                                            $movie9->addMediaFromUrl(RemoveSpecial($dato->caratula))->toMediaCollection('posters');

                                            $movie22 = $movie9;
                                        }
                                    }


                                    $this->info(print_r($dato->fechas[0]->fecha['value'], true));


                                    foreach ($dato->fechas->fecha as $fecha) {
                                        $fechita6 = Carbon::createFromFormat('d/m/Y', $fecha['value']);
                                        $dia6 = date("d/m/Y", strtotime($fechita6));
                                        if ($dia6 == date("d/m/Y")) {
                                            foreach ($fecha->sesiones->sesion as $sesion) {

                                                $time = time();
                                                $hora = date("H:i", $time);
                                                $fechaday = Carbon::createFromFormat('d/m/Y', $fecha['value']);
                                                $fechaday = $fechaday->format('Y-m-d');

                                                Projection::updateOrCreate(array(
                                                    'hour' => $sesion['hora'],

                                                    'movie_id' => $movie22->id,
                                                    'room_id' => $sesion['sala'],
                                                    'cinema_id' => $cinema_id,
                                                    'syncronitation_id' => $syn->id,
                                                ));
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }


            foreach ($xmlObject->ProximosEventos->evento as $dato) {
                if ($dato->titulo['nexp'] == 0) {
                    // $this->info(print_r($dato->titulo['nexp'], true));
                    $cinema_id = 3;
                } else {
                    //$this->info(print_r($dato->titulo['nexp'], true));
                    $cinema_id = 1;
                }

                if (Qualification::where('qualification', $dato->calificacion)->first()) {
                    $qualification = Qualification::where('qualification', $dato->calificacion)->first();
                } else {
                    $qualification = $sinNada;
                }
                if (@URL_exists($dato->caratula)) {
                    if ($dato->titulo) {
                        $imagen2 = file_get_contents($dato->caratula);
                        Storage::disk('mi_poster')->put($dato->titulo . '_posterOrtega.jpg', $imagen2);

                        //$headers = array('Accept' => 'application/json');
                        // $query = array('query' => urlencode(rtrim(rtrim( rtrim($movie->titulo, " 3D"), "-VO-" ), " V.O.S.")), 'language' => 'es');
                        $response = Http::get('https://api.themoviedb.org/3/search/movie?api_key=308fcbf28834111e1abaf741ad70b08d&query=' . $dato->titulo . '&language=es');
                        $arrayResponse = $response->json();

                        $result = current($arrayResponse['results']);

                        if ($result) {
                            //$this->info(print_r( $result['id'], true));

                            $response2 = Http::get('https://api.themoviedb.org/3/movie/' . $result['id'] . '?api_key=308fcbf28834111e1abaf741ad70b08d&language=es');
                            $arrayResponse2 = $response2->json();

                            $pathFondo = $arrayResponse2['backdrop_path'];

                            if ($pathFondo) {
                                // $this->info(print_r($pathFondo, true));

                                $fondo = 'https://image.tmdb.org/t/p/original' . $pathFondo;

                                $imagen = file_get_contents($fondo);
                                Storage::disk('mi_fondo')->put(RemoveSpecialChar($dato->titulo) . '_fondoOrtega.jpg', $imagen);
                                if ($dato->estreno) {
                                    $date10 = Carbon::parse($dato->estreno);
                                    $date10 = $date10->format('Y-m-d');
                                    $mod_date = strtotime($date10 . "+ 7 days");
                                    $dia = date("Y/m/d", $mod_date);
                                    $diaOtro = date("Y/m/d", strtotime($dato->estreno));
                                    if ($diaOtro <= date("Y/m/d")) {
                                        if ($dia >= date("Y/m/d")) {
                                            $estreno = '1';
                                        } else if ($dia < date("Y/m/d")) {
                                            $estreno = null;
                                        }
                                    } else {
                                        if ($dia >= date("Y/m/d")) {
                                            $estreno = null;
                                        } else if ($dia < date("Y/m/d")) {
                                            $estreno = null;
                                        }
                                    }
                                    if ($dato->fechas[0]) {
                                        $fechadayid10 = Carbon::createFromFormat('d/m/Y', $dato->fechas[0]->fecha['value']);
                                        $fechadayid10 = $fechadayid10->format('Y/m/d');
                                        $moviefind11 = Movie::where([
                                            'title' => $dato->titulo,
                                            'buy' => $dato->compra,
                                            'update' => 1,
                                        ])->get();


                                        if ($moviefind11) {
                                            $moviespan11 = Movie::where(
                                                [
                                                    'title' => $dato->titulo,
                                                    'buy' => $dato->compra,
                                                    'update' => 1,
                                                ]
                                            )->get()->first();
                                            $movie22 = $moviespan11;
                                        }

                                        if (!$movie22) {
                                            $movie10 = Movie::updateOrCreate(
                                                [
                                                    'buy' => $dato->compra,
                                                    'update' => 0,
                                                ],
                                                array(
                                                    'title' => $dato->titulo,
                                                    'synopsis' => $dato->sinopsis,
                                                    'duration' => $dato->duracion,


                                                    'trailer' => $dato->trailer,
                                                    'qualification_id' => $qualification->id,
                                                    'type' => $dato->tipodecontenido,

                                                    'premiere' => $date10,
                                                    'buy' => $dato->compra,
                                                    'active' => $estreno,
                                                    'date' => $fechadayid10,
                                                    'update' => 0,
                                                )
                                            );
                                            $movie10->clearMediaCollection('posters');


                                            $movie10->clearMediaCollection('backgrounds');
                                            if ($movie10) {

                                                $movie10->clearMediaCollection('posters');


                                                $movie10->clearMediaCollection('backgrounds');

                                                $movie10->addMediaFromUrl(RemoveSpecial($dato->caratula))->toMediaCollection('posters');
                                                $movie10->addMediaFromUrl('https://image.tmdb.org/t/p/original' . $pathFondo)->toMediaCollection('backgrounds');
                                                $movie22 = $movie10;
                                            }
                                        }

                                        $this->info(print_r($dato->fechas[0]->fecha['value'], true));
                                        foreach ($dato->fechas as $fecha) {

                                            foreach ($fecha->fecha->sesiones->sesion as $sesion) {
                                                $fechaday3 = Carbon::createFromFormat('d/m/Y', $fecha->fecha['value']);
                                                $fechaday3 = $fechaday3->format('d/m/Y');
                                                Projection::updateOrCreate(array(
                                                    'hour' => $sesion['hora'],
                                                    'release_date' => $fechaday3,
                                                    'movie_id' => $movie22->id,
                                                    'room_id' => $sesion['sala'],
                                                    'cinema_id' => $cinema_id,
                                                    'syncronitation_id' => $syn->id,
                                                ));
                                            }
                                        }
                                    }
                                }
                            } else {
                                if ($dato->estreno) {
                                    $date11 = Carbon::parse($dato->estreno);
                                    $date11 = $date11->format('Y-m-d');
                                    $mod_date = strtotime($date11 . "+ 7 days");
                                    $dia = date("Y/m/d", $mod_date);
                                    // $this->info(print_r( "1".$date01, true));
                                    // $this->info(print_r( "2".$dia, true));

                                    $diaOtro = date("Y/m/d", strtotime($dato->estreno));
                                    if ($diaOtro <= date("Y/m/d")) {
                                        if ($dia >= date("Y/m/d")) {
                                            $estreno = '1';
                                        } else if ($dia < date("Y/m/d")) {
                                            $estreno = null;
                                        }
                                    } else {
                                        if ($dia >= date("Y/m/d")) {
                                            $estreno = null;
                                        } else if ($dia < date("Y/m/d")) {
                                            $estreno = null;
                                        }
                                    }
                                    if ($dato->fechas[0]) {
                                        $fechadayid11 = Carbon::createFromFormat('d/m/Y', $dato->fechas[0]->fecha['value']);
                                        $fechadayid11 = $fechadayid11->format('Y/m/d');
                                        $moviefind12 = Movie::where([
                                            'title' => $dato->titulo,
                                            'buy' => $dato->compra,
                                            'update' => 1,
                                        ])->get();

                                        if ($moviefind12) {
                                            $moviespan12 = Movie::where(
                                                [
                                                    'title' => $dato->titulo,
                                                    'buy' => $dato->compra,
                                                    'update' => 1,
                                                ]
                                            )->get()->first();
                                            $movie22 = $moviespan12;
                                        }

                                        if (!$movie22) {
                                            $movie11 = Movie::updateOrCreate(
                                                [
                                                    'buy' => $dato->compra,
                                                    'update' => 0,
                                                ],
                                                array(
                                                    'title' => $dato->titulo,
                                                    'synopsis' => $dato->sinopsis,
                                                    'duration' => $dato->duracion,

                                                    'trailer' => $dato->trailer,
                                                    'qualification_id' => $qualification->id,
                                                    'type' => $dato->tipodecontenido,
                                                    'premiere' => $date11,
                                                    'buy' => $dato->compra,
                                                    'active' => $estreno,
                                                    'date' => $fechadayid11,
                                                    'update' => 0,
                                                )
                                            );
                                            $movie11->clearMediaCollection('posters');


                                            $movie11->clearMediaCollection('backgrounds');
                                            if ($movie11) {

                                                $movie11->clearMediaCollection('posters');


                                                $movie11->clearMediaCollection('backgrounds');

                                                $movie11->addMediaFromUrl(RemoveSpecial($dato->caratula))->toMediaCollection('posters');

                                                $movie22 = $movie11;
                                            }
                                        }

                                        $this->info(print_r($dato->fechas[0]->fecha['value'], true));


                                        foreach ($dato->fechas as $fecha) {

                                            foreach ($fecha->fecha->sesiones->sesion as $sesion) {
                                                $fechaday4 = Carbon::createFromFormat('d/m/Y', $fecha->fecha['value']);
                                                $fechaday4 = $fechaday4->format('d/m/Y');
                                                Projection::updateOrCreate(array(
                                                    'hour' => $sesion['hora'],
                                                    'release_date' => $fechaday4,
                                                    'movie_id' => $movie22->id,
                                                    'room_id' => $sesion['sala'],
                                                    'cinema_id' => $cinema_id,
                                                    'syncronitation_id' => $syn->id,
                                                ));
                                            }
                                        }
                                    }
                                }
                            }

                            $response3 = Http::get('https://api.themoviedb.org/3/movie/' . $result['id'] . '/credits?api_key=308fcbf28834111e1abaf741ad70b08d&language=es');
                            $arrayResponse3 = $response3->json();

                            $cast = $arrayResponse3['cast'];
                            $crew = $arrayResponse3['crew'];


                            if ($cast) {
                                $movie22->actors()->detach();
                                foreach ($cast as $actor) {
                                    if ($actor['known_for_department'] == 'Acting') {
                                        $arrayActor2 = Actor::updateOrCreate(array(
                                            'actor' => $actor['name'],

                                        ));

                                        $movie22->actors()->attach($arrayActor2->id);
                                    }
                                }
                            }

                            if ($crew) {
                                $movie22->directors()->detach();
                                foreach ($crew as $director) {
                                    if ($director['job'] == 'Director') {
                                        $arrayDirector2 = Director::updateOrCreate(array(
                                            'director' => $director['name'],
                                        ));

                                        $movie22->directors()->attach($arrayDirector2->id);
                                    }
                                }
                            }
                        } else {
                            if ($dato->estreno) {
                                $date12 = Carbon::parse($dato->estreno);
                                $date12 = $date12->format('Y-m-d');
                                $mod_date = strtotime($date12 . "+ 7 days");
                                $dia = date("Y/m/d", $mod_date);

                                $diaOtro = date("Y/m/d", strtotime($dato->estreno));
                                if ($diaOtro <= date("Y/m/d")) {
                                    if ($dia >= date("Y/m/d")) {
                                        $estreno = '1';
                                    } else if ($dia < date("Y/m/d")) {
                                        $estreno = null;
                                    }
                                } else {
                                    if ($dia >= date("Y/m/d")) {
                                        $estreno = null;
                                    } else if ($dia < date("Y/m/d")) {
                                        $estreno = null;
                                    }
                                }
                                if ($dato->fechas[0]) {
                                    $fechadayid12 = Carbon::createFromFormat('d/m/Y', $dato->fechas[0]->fecha['value']);
                                    $fechadayid12 = $fechadayid12->format('Y/m/d');
                                    $moviefind13 = Movie::where([
                                        'title' => $dato->titulo,
                                        'buy' => $dato->compra,
                                        'update' => 1,
                                    ])->get();

                                    if ($moviefind13) {
                                        $moviespan13 = Movie::where(
                                            [
                                                'title' => $dato->titulo,
                                                'buy' => $dato->compra,
                                                'update' => 1,
                                            ]
                                        )->get()->first();
                                        $movie22 = $moviespan13;
                                    }

                                    if (!$movie22) {
                                        $movie12 = Movie::updateOrCreate(
                                            [
                                                'buy' => $dato->compra,
                                                'update' => 0,
                                            ],
                                            array(
                                                'title' => $dato->titulo,
                                                'synopsis' => $dato->sinopsis,
                                                'duration' => $dato->duracion,

                                                'trailer' => $dato->trailer,
                                                'qualification_id' => $qualification->id,
                                                'type' => $dato->tipodecontenido,
                                                'premiere' => $date12,
                                                'buy' => $dato->compra,
                                                'active' => $estreno,
                                                'date' => $fechadayid12,
                                                'update' => 0,
                                            )
                                        );
                                        $movie12->clearMediaCollection('posters');

                                        if ($movie12) {

                                            $movie12->clearMediaCollection('posters');


                                            $movie12->addMediaFromUrl(RemoveSpecial($dato->caratula))->toMediaCollection('posters');

                                            $movie22 = $movie12;
                                        }
                                    }

                                    $this->info(print_r($dato->fechas[0]->fecha['value'], true));

                                    foreach ($dato->fechas as $fecha) {
                                        foreach ($fecha->fecha->sesiones->sesion as $sesion) {
                                            $fechaday = Carbon::createFromFormat('d/m/Y', $fecha->fecha['value']);
                                            $fechaday = $fechaday->format('d/m/Y');
                                            Projection::updateOrCreate(array(
                                                'hour' => $sesion['hora'],
                                                'release_date' => $fechaday,
                                                'movie_id' => $movie22->id,
                                                'room_id' => $sesion['sala'],
                                                'cinema_id' => $cinema_id,
                                                'syncronitation_id' => $syn->id,
                                            ));
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $this->info(print_r('no esta disponible el cine ortega', true));
        }
    }
}
