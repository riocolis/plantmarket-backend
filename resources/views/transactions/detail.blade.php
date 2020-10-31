<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Transaction &raquo; {{ $item->plant->name }} by {{ $item->user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
           <div class="w-full rounded overflow-hidden shadow-lg px-6 py-6 bg-white">
               <div class="flex fex-wrap mx-4 mb-4 md:mb-0">
                    <div class="w-full md:w-1/6 px-4 mb-4 md:mb-0">
                        <img src="{{ $item->plant->picturePath }}" alt="" class="w-full rounded">
                    </div>
                    <div class="w-full md:w-5/6 px-4 mb-4 md:mb-@">
                        <div class="flex flex-wrap mb-3">
                            <div class="w-2/6">
                                <div class="text-sm">Product Name</div>
                                <div class="text-xl font-bold">{{ $item->plant->name }}</div>
                            </div>
                            <div class="w-1/6">
                                <div class="text-sm">Quantity</div>
                                <div class="text-xl font-bold">{{ number_format($item->quantity) }}</div>
                            </div>
                            <div class="w-1/6">
                                <div class="text-sm">Total</div>
                                <div class="text-xl font-bold">{{ number_format($item->total) }}</div>
                            </div>
                            <div class="w-1/6">
                                <div class="text-sm">Status</div>
                                <div class="text-xl font-bold">{{ $item->total }}</div>
                            </div>
                        </div>
                        <div class="flex flex-wrap mb-3">
                            <div class="w-2/6">
                                <div class="text-sm">User Name</div>
                                <div class="text-xl font-bold">{{ $item->user->name }}</div>
                            </div>
                            <div class="w-3/6">
                                <div class="text-sm">Email</div>
                                <div class="text-xl font-bold">{{ $item->user->email }}</div>
                            </div>
                            <div class="w-1/6">
                                <div class="text-sm">City</div>
                                <div class="text-xl font-bold">{{ $item->user->city }}</div>
                            </div>
                        </div>
                        <div class="flex flex-wrap mb-3">
                            <div class="w-4/6">
                                <div class="text-sm">Address</div>
                                <div class="text-xl font-bold">{{ $item->user->address }}</div>
                            </div>
                            <div class="w-1/6">
                                <div class="text-sm">House Number</div>
                                <div class="text-xl font-bold">{{ $item->user->houseNumber }}</div>
                            </div>
                            <div class="w-1/6">
                                <div class="text-sm">Phone</div>
                                <div class="text-xl font-bold">{{ $item->user->phone }}</div>
                            </div>
                        </div>
                        <div class="flex flex-wrap mb-3">
                            <div class="w-5/6">
                                <div class="text-sm">Payment URL</div>
                                <div class="text-lg font-bold"><a href="{{ $item->payment_url }}">{{ $item->payment_url }}</a></div>
                            </div>
                            <div class="w-1/6">
                                <div class="text-sm mb-1">ChangeStatus</div>
                                <a href="{{ route('transactions.changeStatus'. ['id' => $item->id, 'status' => 'ON_DELIVERY']) }}"
                                    class="b-blue-500 hover:bg-blue-700 text-white font-bold px-2 rounded block text-center w-full mb-1">
                                    ON DELIVERY
                                </a>
                                <a href="{{ route('transactions.changeStatus'. ['id' => $item->id, 'status' => 'DELIVERED']) }}"
                                    class="b-green-500 hover:bg-blue-700 text-white font-bold px-2 rounded block text-center w-full mb-1">
                                    DELIVERED
                                </a>
                                <a href="{{ route('transactions.changeStatus'. ['id' => $item->id, 'status' => 'CANCELLED']) }}"
                                    class="b-blue-500 hover:bg-blue-700 text-white font-bold px-2 rounded block text-center w-full mb-1">
                                    CANCELLED
                                </a>
                            </div>
                        </div>
                    </div>
               </div>
           </div>
        </div>
    </div>
</x-app-layout>