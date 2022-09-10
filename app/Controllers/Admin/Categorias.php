<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entities\Categoria;


class Categorias extends BaseController
{

    private $categoriaModel;

    public function __construct(){

        $this->categoriaModel = new \App\Models\CategoriaModel();
    }
    public function index()
    {

        $data = [

            'titulo' => 'Listando as categorias',
            'categorias' => $this->categoriaModel->withDeleted(true)->paginate(10),
            'pager' => $this->categoriaModel->pager
        ];

        return view('Admin/Categorias/index', $data);
        
    }

    public function procurar(){

        //IF para não mostrar ao usuário. Pois ele só deve ser acessado via AJAX REQUEST. 
         if(!$this->request->isAJAX()){
 
             exit('Página não encontrada');
         }
 
         $categorias = $this->categoriaModel->procurar($this->request->getGet('term'));
 
         $retorno = [];
 
         foreach ($categorias as $categoria) {
 
             //Esse id é do index.php de admin/categorias dentro do else.
             //O valure é do index.php de admin/categorias dentro do if.
 
             $data['id'] = $categoria->id;
             $data['value'] = $categoria->nome;
 
             $retorno[] = $data;
 
         }
 
         return $this->response->setJSON($retorno);
 
         
     }
     public function criar(){

        $categoria = new Categoria();

    $data = [

        'titulo' => "Cadastrando nova categoria",
        'categoria' => $categoria,
    ];

    return view ('Admin/Categorias/criar', $data);
    }

     public function show($id = null){

        //categoria ta sendo criado através da recupoeração do metodo buscacategoriaOu404
        $categoria = $this->buscaCategoriaOu404($id);

        
       
        $data = [
            'titulo' => "Detalhando a Categoria $categoria->nome",
            'categoria' => $categoria,
        ];

        return view('Admin/Categorias/show', $data);
    }

    public function editar($id = null){

        //categoria ta sendo criado através da recupoeração do metodo buscacategoriaOu404
        $categoria = $this->buscaCategoriaOu404($id);

        
       
        if($categoria->deletado_em != null){
            
            return redirect()->back()->with('info', "A Categoria $categoria->nome encontra-se excluído. Logo, não é possível editá-lô.");
        }
        $data = [
            'titulo' => "Editando a Categoria $categoria->nome",
            'categoria' => $categoria,
        ];

        return view('Admin/Categorias/editar', $data);
    }

    public function atualizar($id = null){

        if($this->request->getMethod() === 'post'){

            $categoria = $this->buscaCategoriaOu404($id);


            if($categoria->deletado_em != null){
            
                return redirect()->back()->with('info', "A Categoria $categoria->nome encontra-se excluído. Logo, não é possível editá-la.");
            }

            
            $categoria->fill($this->request->getPost());

            //se não for alterado nada na edição.
            if(!$categoria->hasChanged()){

                return redirect()->back()->with('info', 'Não há dados para atualizar.');
            }

           

            if($this->categoriaModel->save($categoria)){

                return redirect()->to(site_url("admin/categorias/show/$categoria->id"))->with('sucesso', "Categoria $categoria->nome atualizado com sucesso");
           
            }else{

                return redirect()->back()->with('errors_model', $this->categoriaModel->errors())->with('atencao', 'Dados inválidos, favor verificar.')->withInput();


            }


        }else{

            /* Não é post */

            return redirect()->back();

        }
    }


    /**
     * 
     * @param int $id
     * @return objeto usuário
     */

    private function buscaCategoriaOu404(int $id = null){

        if(!$id || !$categoria = $this->categoriaModel->withDeleted(true)->where('id', $id)->first()){

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos a Categoria $id");
        }

        return $categoria;
    }
}
