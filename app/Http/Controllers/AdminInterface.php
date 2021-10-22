<?php

namespace App\Http\Controllers;

use App\User;
use App\Model\RecordTable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class AdminInterface extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        Cookie::queue('dibbling_token', Auth::user()->api_token, 120);

        // get all user's dibbling record
        $record_dibbling_query = RecordTable::select( 'record.user_id', DB::raw( 'count(record.id) as dibbling_count' ) )
            ->where( 'record_type', '=', RecordTable::DIBBLING )
            ->groupBy( 'record.user_id' );
        $record_re_query = RecordTable::select( 'record.user_id', DB::raw( 'count(record.id) as re_count' ) )
            ->where( 'record_type', '=', RecordTable::RE_DIBBLING )
            ->groupBy( 'record.user_id' );

        $users = User::select( 'users.*', 'rd.dibbling_count', 'rd.dibbling_count', 're.re_count' )
            ->leftJoin( DB::raw( "({$record_dibbling_query->toSql()}) as rd" ), function( $join ) use ( $record_dibbling_query )
            {
                $join->on('users.id', '=', 'rd.user_id')->addBinding( $record_dibbling_query->getBindings() );
            } )
            ->leftJoin( DB::raw( "({$record_re_query->toSql()}) as re" ), function( $join ) use ( $record_re_query )
            {
                $join->on('users.id', '=', 're.user_id')->addBinding( $record_re_query->getBindings() );
            } )
            ->get();

        return view( 'admin_interface', [ 'users' => $users ] );
    }
}
