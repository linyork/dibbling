

namespace App\Http\Controllers;

class Dibbling extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('dibbling');
    }
}
