<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\AddressMakeDefaultRequest;
use App\Http\Requests\Api\User\AddressRequest;
use App\Http\Resources\Api\User\AddressesResources;
use App\Models\Address;
use App\Models\Zone;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\Request;


class AddressesController extends Controller
{

    public function index(Request $request)
    {
        $data = Address::where('user_id', auth('user')->user()->id)
            ->orderBy('is_default', 'desc')
            ->paginate(Config('app.paginate'));
        $data = AddressesResources::collection($data)->response()->getData(true);
        return msgdata(true, trans('lang.data_display_success'), $data, success());

    }

    public function details(AddressMakeDefaultRequest $request)
    {
        $data = Address::where('user_id', auth('user')->user()->id)->where('id', $request['id'])
            ->orderBy('id', 'desc')
            ->first();
        $data = new AddressesResources($data);
        return msgdata(true, trans('lang.data_display_success'), $data, success());

    }

    public function store(AddressRequest $request)
    {
        $request = $request->validated();
        //check if this first address or not
        $exists_address = Address::where('user_id', auth('user')->user()->id)->first();
        if (!$exists_address) {
            $request['is_default'] = 1;
        }
        $request['user_id'] = auth('user')->user()->id;


        //check my location in zone to generate shipping cost
        $point = new Point($request['lat'], $request['lng']);
        $zone = Zone::contains('coordinates', $point)->whereId(1)->first();
        if ($zone) {
            $request['location'] = 'in_riyadh';
        } else {
            $request['location'] = 'out_riyadh';
        }
        $saudi_zone = Zone::contains('coordinates', $point)->whereId(2)->first();
        if (!$saudi_zone) {
            return msg(true, trans('lang.you_are_out_saudi'), not_accepted());
        }
        Address::create($request);
        return msg(true, trans('lang.added_s'), success());

    }

    public function update(AddressRequest $request)
    {
        $request = $request->validated();

        //check my location in zone to generate shipping cost
        $point = new Point($request['lat'], $request['lng']);
        $zone = Zone::contains('coordinates', $point)->whereId(1)->first();
        if ($zone) {
            $request['location'] = 'in_riyadh';
        } else {
            $request['location'] = 'out_riyadh';
        }
        $saudi_zone = Zone::contains('coordinates', $point)->whereId(2)->first();
        if (!$saudi_zone) {
            return msg(true, trans('lang.you_are_out_saudi'), not_accepted());
        }
        Address::where('id', $request['id'])->update($request);
        return msg(true, trans('lang.updated_s'), success());
    }

    public function makeDefault(AddressMakeDefaultRequest $request)
    {
        $request = $request->validated();
        //check if this first address or not
        $exists_address = Address::where('user_id', auth('user')->user()->id)->where('id', $request['id'])->first();
        if (!$exists_address) {
            return msg(true, trans('lang.should_choose_your_address'), failed());

        } else {
            Address::where('user_id', auth('user')->user()->id)->update(['is_default' => 0]);
            $exists_address->is_default = 1;
            $exists_address->save();
            return msg(true, trans('lang.updated_s'), success());

        }

    }

    public function delete(AddressMakeDefaultRequest $request)
    {
        $request = $request->validated();
        //check if this first address or not
        $exists_address = Address::where('user_id', auth('user')->user()->id)->where('id', $request['id'])->first();
        if (!$exists_address) {
            return msg(true, trans('lang.should_choose_your_address'), failed());
        } else {
            $exists_address->delete();
            return msg(true, trans('lang.deleted_s'), success());

        }

    }


}
