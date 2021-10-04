<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Certificado;
use App\Models\User;
use Illuminate\Http\Request;
use phpseclib3\File\X509;

class CertificadoController extends Controller
{
    public array $extensions = ['pem'];
    public function index()
    {
        $certificados = Certificado::all();
        return $certificados;
    }

  
    public function store(Request $request)
    {   
    
        $data=$request->certificado;
        $x509 = new X509();
        $cert = $x509->loadX509(file_get_contents($data));

        $dataCertificado= $this->getissuedCertificate($cert);
        $issuerName=$this->getissuerName($cert);
        $subjectName=$this->getsubjectName($cert);
        $titular=$this->getTitularCertificado($cert);
    
        $certificado["dataValidade"]=$dataCertificado['create'];
        $certificado['dn']=$issuerName;
        $certificado['inssuerDn']=$subjectName;
        $certificado['titular']=$titular[5];
        $certificado['usuario_id']=$request->usuario_id;        

        $certificadoCreate=Certificado::create($certificado);
        return $certificadoCreate;
    }

    private function getissuedCertificate($cert)
    {
        $notBefore=$cert['tbsCertificate']['validity']['notBefore']['utcTime'];
        $notAfter=$cert['tbsCertificate']['validity']['notAfter']['utcTime'];   
        $data["create"]=strtotime($notBefore);
        $data["validity"]=strtotime($notAfter);
        return $data;
    }

    private function getissuerName($cert)
    {   
        $result="";      
        for($i = 0; $i < 5; $i++)
        {
            $issuerName[$i]=$cert['tbsCertificate']['issuer']['rdnSequence'][$i]['0']['value']['printableString'];
            $result.= $issuerName[$i];         
        }
        return $result;
    }

    private function getTitularCertificado($cert)
    {   
             
        for($i = 0; $i < 6; $i++)
        {
            $titular[$i]=$cert['tbsCertificate']['subject']['rdnSequence'][$i]['0']['value']['printableString'];
                     
        }
        return $titular;
    }

    private function getsubjectName($cert)
    {    
        $result="";   
        for($i = 0; $i < 6; $i++)
        {
            $subjectName[$i]=$cert['tbsCertificate']['subject']['rdnSequence'][$i]['0']['value']['printableString'];     
            $result.= $subjectName[$i];  
        } 
        return $result;      
    }

 
    public function show(Certificado $certificado)
    {
        // dd($certificado);
        $certificado = Certificado::find($certificado);
        
        return $certificado;  
    }


    public function update(Request $request, Certificado $certificado)
    {
        $data=$request->certificado;
        $x509 = new X509();
        $cert = $x509->loadX509(file_get_contents($data));

        $dataCertificado= $this->getissuedCertificate($cert);
        $issuerName=$this->getissuerName($cert);
        $subjectName=$this->getsubjectName($cert);
        $titular=$this->getTitularCertificado($cert);
    
        dd($titular);

        $certificado["dataValidade"]=$dataCertificado['create'];
        $certificado['dn']=$issuerName;
        $certificado['inssuerDn']=$subjectName;
        $certificado['titular']=$titular[5];
        $certificado['usuario_id']=$request->usuario_id;  
      
        dd( $certificado);
        $certificado->update($request->all());
        return[];
        $data=$request->certificado;
        dd($data);
    }

    private function uploadFile($data)
    {

        if (!$data) {
            return response()->json(['error' => "invalid certificate"], 422);
        }
        if (!in_array($data->getClientOriginalExtension(), $this->extensions)) {
            return response()->json(['error' => "invalid extensions"], 422);
        }

        $novoNome = uniqid() . ".{$data->getClientOriginalExtension()}";
        $data->storeAs('certificado', $novoNome);
        return $novoNome;
    }

    private function getCertificateData($data)
    {
        $cert = file_get_contents($data);
        $certinfo = openssl_x509_parse($cert);
        return [
            'subjectDN' => $this->getSubjectData($certinfo['subject']),
            'issuerDN' => $this->getIssuerData($certinfo['issuer']),
            'validFrom' => $certinfo['validFrom'],
            'validTo' => $certinfo['validTo']
        ];
    }

    
    public function destroy(Certificado $certificado)
    {
        $certificado->delete();
        return[];
    }


}
