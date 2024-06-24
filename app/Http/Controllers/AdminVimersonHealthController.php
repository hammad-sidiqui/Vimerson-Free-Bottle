<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;


use App\Exports\BulkExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Artisan;

// Models
use App\Models\Bottle;
use App\Models\Questionnaire;
use App\Models\FormTimeTracker;
use App\Models\MetaData;
use App\Models\ProductDetails;
use App\Models\VerifiedAsin;
use App\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class AdminVimersonHealthController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /** list all free bottle */
    public function index(Bottle $model)
    {
        $bottles = $model->getActiveBottles();
        return view('admin.bottle.index', compact('bottles'));
    }

    /** create free bottle form */
    public function create()
    {
        return view('admin.bottle.create');
    }

    /** add free bottle to DB */
    public function store(Bottle $model)
    {
        $data = request()->all();

        request()->validate([
            'variant_id' => 'required|string',
            'asin'       => 'required|string',
            'name'       => 'required|string',
            'price'      => 'integer',
            'status'     => 'string',
            // 'featured'   => 'string',
            'image'      => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $file_name = '';

        if ($files = request()->file('image')) {
            $file_name =  'bottle-' . time() . '.' . request()->image->extension();
            request()->image->storeAs('media\bottle\images', $file_name);
        }

        $data['slug'] = str_replace(' ', '-', strtolower(request()->name));
        $data['image'] = $file_name;

        try {
            $model->create($data);
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return redirect('/admin/bottle')->with('flash_message', 'Free bottle created');
    }

    /** edit free bottle form */
    public function edit(Bottle $model, $id)
    {
        $bottle = $model->findOrFail($id);
        return view('admin.bottle.edit', compact('bottle'));
    }

    /** update free bottle to DB */
    public function update(Bottle $model, $id)
    {
        $bottle = $model->findOrFail($id);

        $data = request()->all();

        request()->validate([
            'name'     => 'required|string',
            'price'    => 'integer',
            'status'   => 'string',
            // 'featured' => 'string',
            // 'image'    => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $file_name = '';
        if ($files = request()->file('image')) {
            $file_name =  'bottle-' . time() . '.' . request()->image->extension();
            request()->image->storeAs('media\bottle\images', $file_name);
            $data['image'] = $file_name;
        }

        $data['slug'] = str_replace(' ', '-', strtolower(request()->name));

        try {
            $bottle->update($data);
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return redirect('/admin/bottle')->with('flash_message', 'Free bottle updated');
    }

    /** delete bottle (change status) */
    public function deleteBottle(Bottle $model, $id)
    {
        $bottle = $model->findOrFail($id);
        $bottle->update(['status' => '0']);
        return redirect('admin/bottle')->with('flash_message', 'Bottle deleted successfully');
    }

    /** delete bottle (change status) */
    public function deleteSingleBottle(Bottle $model)
    {
        $data = request()->all();

        $validator = Validator::make($data, [
            'id'  => 'required'
        ]);

        if ($validator->fails()) return $this->resValidator(current($validator->errors()->all()));

        if ($bottle = $model->find($data['id'])) {
            $bottle->update(['status' => '0']);
            return $this->resSuccess('Bottle deleted successfully');
        }

        return $this->resSuccess('Invalid ID');
    }

    /** delete bottle */
    public function deleteSingleProduct(ProductDetails $model)
    {
        $data = request()->all();

        $validator = Validator::make($data, [
            'id'  => 'required'
        ]);

        if ($validator->fails()) return $this->resValidator(current($validator->errors()->all()));

        if ($peoduct = $model->find($data['id'])) {
            $peoduct->delete();
            return $this->resSuccess('ASIN deleted successfully');
        }

        return $this->resSuccess('Invalid ID');
    }

    /** list all active question */
    public function questionList(Questionnaire $model)
    {
        $questions = $model->getActiveQuestionnaire();
        return view('admin.questionnaire.index', compact('questions'));
    }

    /** create question form */
    public function questionCreateForm()
    {
        return view('admin.questionnaire.create');
    }

    /** add question to DB */
    public function questionStore(Questionnaire $model)
    {
        $data = request()->all();

        request()->validate([
            'question' => 'required|string',
            'status'   => 'string',
            'featured' => 'string'
        ]);

        try {
            $model->create($data);
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return redirect('/admin/questionnaire')->with('flash_message', 'Questionnaire created');
    }

    /** question edit form */
    public function questionEditForm(Questionnaire $model, $id)
    {
        $question = $model->findOrFail($id);
        return view('admin.questionnaire.edit', compact('question'));
    }

    /** update question to DB */
    public function questionUpdate(Questionnaire $model, $id)
    {
        $question = $model->findOrFail($id);

        $data = request()->all();

        request()->validate([
            'question'     => 'required|string',
            'status'   => 'string',
            'featured' => 'string'
        ]);

        try {
            $question->update($data);
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return redirect('/admin/questionnaire')->with('flash_message', 'Questionnaire updated');
    }

    /** list all timetracker */
    public function timeTrackerList(FormTimeTracker $model)
    {
        $time_tracker = $model->getAllTimeTracker();
        return view('admin.timetracker.index', compact('time_tracker'));
    }

    /** list all users */
    public function userList(User $model)
    {
        $users = $model->getUserlist();
        return view('admin.user.index', compact('users'));
    }

    /** export users data */
    protected function exportUsers()
    {
        return Excel::download(new BulkExport, 'bulkUser.xlsx');
    }

    /** list all asin */
    public function listAsin(VerifiedAsin $model)
    {
        $asin = $model->getAllAsin();
        return view('admin.asin.index', compact('asin'));
    }

    /** create asin form */
    public function createAsinForm()
    {
        return view('admin.asin.create');
    }

    /** add asin to DB */
    public function storeAsin(VerifiedAsin $model)
    {
        $data = request()->all();

        request()->validate([
            'asin'     => 'required|string',
            'status'    => 'integer'
        ]);

        $asin_list = explode(',', request('asin'));

        $verified_asin = [];

        foreach ($asin_list as $value) {
            $verified_asin[] = [
                'asin' => $value,
                'status' => request('status')
            ];
        }

        try {
            $model->insertListData($verified_asin);
        } catch (Exception $e) {
            return redirect('/admin/asin/create')->with('error_flash', $e->getMessage());
        }

        return redirect('/admin/asin')->with('flash_message', 'Asin created');
    }

    /** edit asin form */
    public function editAsinForm(VerifiedAsin $model, $id)
    {
        $asin = $model->findOrFail($id);
        return view('admin.asin.edit', compact('asin'));
    }

    /** update asin to DB */
    public function updateAsin(VerifiedAsin $model, $id)
    {
        $asin = $model->findOrFail($id);

        $data = request()->all();

        request()->validate([
            'asin'     => 'required|string',
            'status'    => 'integer'
        ]);

        try {
            $asin->update($data);
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return redirect('/admin/asin')->with('flash_message', 'Asin updated');
    }

    /** handle amazon popup button */
    public function handleAmazonPopup(MetaData $model)
    {
        try {
            $model->updateValueByKey('allow_amazon_popup', request('amazon_popup'));
            return $this->resSuccess('updated');
        } catch (Exception $e) {
            return $this->resBadRequest($e->getMessage());
        }
    }

    /** get amazon popup button status */
    public function getAmazonPopupStauts(MetaData $model)
    {
        try {
            $popup = $model->findByKey('allow_amazon_popup', 'first')->meta_value;
            return $this->resSuccess('', $popup);
        } catch (Exception $e) {
            return $this->resBadRequest($e->getMessage());
        }
    }

    /** get bottle by ASIN */
    public function getBottleByAsin(Bottle $model, ProductDetails $p_model)
    {
        $data = request()->all();
        $bottle = [];

        $validator = Validator::make($data, [
            'asin'  => 'required|string',
            'selected_items' => 'required'
        ]);

        if ($validator->fails()) return $this->resValidator(current($validator->errors()->all()));

        // this check only for create asin
        if ($data['selected_items'] == 'false' && $p_model->getProductByAsin($data['asin'])) {
            return $this->resConflict('ASIN already exists');
        }

        try {
            if ($bottle_info = $model->bottleByAsin($data['asin'])) {
                $bottle['bottle_info'] = $bottle_info;
                // $bottle['bottle_list'] = $model->getBottleList(['id', 'name AS text'], [$data['asin']]);
                $bottle['bottle_list'] = $model->getBottleList(['id', 'name AS text']);

                if (isset($data['selected_items']) && $data['selected_items'] == 'true') {
                    $bottle['selected_values'] = json_decode($p_model->productBottlesByAsin($data['asin']), true);
                }
            } else {
                return $this->resNotFound('Invalid ASIN');
            }
        } catch (Exception $e) {
            return $this->resBadRequest($e->getMessage());
        }

        return $this->resSuccess('', $bottle);
    }

    /** get bottle images by ASIN */
    public function getBottleImagesByAsin(Bottle $model)
    {
        $data = request()->all();

        $validator = Validator::make($data, [
            'id'  => 'required|array'
        ]);

        if ($validator->fails()) return $this->resValidator(current($validator->errors()->all()));

        try {
            $images = $model->bottleImageByID($data['id']);

            if (request('type') === 'html') {
                return view('ajax_pages.selected_bottles', compact('images'))->render();
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return $this->resSuccess('', $images);
    }
}
