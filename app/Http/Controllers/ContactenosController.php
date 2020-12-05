<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Contactame;

use Mail;
class ContactenosController extends Controller
{
    public function index(){
    	return view('web.contacto.index');
    }

    public function enviar(Request $request){

    	$this->validate($request, [


        'nombre' => 'required|min:3|regex:/^[\pL\s\-]+$/u',


        'email' => 'required|email',
        'telefono' => 'required|numeric|digits_between:6,15',


        'mensaje' => 'required|min:10'


        ]);
       

    	$Contactame =Contactame::create($request->all());
         $datos=["Nombre"=>$request->nombre,
                "Email" => $request->email,
                "Telefono"=>$request->telefono,
                "Mensaje"=>$request->mensaje
               ];
               //email
        $subject = "Mensaje enviado desde la pagina web";
            $for ='upallanosorientales@gmail.com';
            try{
              $envioMail=Mail::send('email.index',$datos, function($msj) use($subject,$for){
                $msj->from("sugerenciasupallanos@gmail.com","Mensaje pagina web");
                $msj->subject($subject);
                $msj->to($for);
            });
          }
          catch(\Swift_RfcComplianceException $transportExp){

            //mensaje no enviado


        }

    }
}
