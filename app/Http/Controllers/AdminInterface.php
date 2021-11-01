<?php

namespace App\Http\Controllers;

use App\Model\UserModel;
use App\Model\RecordModel;
use Illuminate\Support\Facades\DB;

class AdminInterface extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // get all user's dibbling record
        $record_dibbling_query = RecordModel::select( 'record.user_id', DB::raw( 'count(record.id) as dibbling_count' ) )
            ->where( 'record_type', '=', RecordModel::DIBBLING )
            ->groupBy( 'record.user_id' );
        $record_re_query = RecordModel::select( 'record.user_id', DB::raw( 'count(record.id) as re_count' ) )
            ->where( 'record_type', '=', RecordModel::RE_DIBBLING )
            ->groupBy( 'record.user_id' );

        $users = UserModel::select( 'users.*', 'rd.dibbling_count', 'rd.dibbling_count', 're.re_count' )
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
