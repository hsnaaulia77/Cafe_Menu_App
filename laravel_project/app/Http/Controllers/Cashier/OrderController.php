namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Menu;

class OrderController extends Controller
{
    // Daftar pesanan baru
    public function index()
    {
        $orders = Order::whereIn('status', ['baru', 'diproses'])->get();
        return view('cashier.orders.index', compact('orders'));
    }

    // Form pembayaran
    public function payment($orderId)
    {
        $order = Order::findOrFail($orderId);
        return view('cashier.orders.payment', compact('order'));
    }

    // Proses pembayaran
    public function pay(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        $request->validate([
            'metode_pembayaran' => 'required|in:tunai,qris',
        ]);
        $order->status = 'lunas';
        $order->metode_pembayaran = $request->metode_pembayaran;
        $order->save();
        return redirect()->route('cashier.orders.index')->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }

    // Form input pesanan manual
    public function createManual()
    {
        $menus = Menu::all();
        return view('cashier.orders.create_manual', compact('menus'));
    }

    // Simpan pesanan manual
    public function storeManual(Request $request)
    {
        if (auth()->user()->role !== 'cashier') {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'jumlah' => 'required|integer|min:1',
            'catatan' => 'nullable|string',
        ]);
        $order = new Order();
        $order->menu_id = $request->menu_id;
        $order->jumlah = $request->jumlah;
        $order->catatan = $request->catatan;
        $order->status = 'lunas';
        $order->is_manual = true;
        $order->save();
        return redirect()->route('cashier.orders.index')->with('success', 'Pesanan manual berhasil ditambahkan.');
    }

    // Cetak struk
    public function print($orderId)
    {
        $order = Order::findOrFail($orderId);
        return view('cashier.orders.print', compact('order'));
    }

    // Riwayat transaksi
    public function history()
    {
        $orders = Order::where('status', 'lunas')->orderBy('updated_at', 'desc')->get();
        return view('cashier.transactions.index', compact('orders'));
    }
}
