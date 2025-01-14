<x-app-layout>

    <div class="container mx-auto py-8">
        <div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg overflow-hidden"> <!-- Modified this line -->
            <div class="py-4 px-6">
            <h1 class="text-xl font-medium mb-6">
                転売

              </h1>


             <h2 class="text-lg font-semibold mb-4 pb-2 border-b">新規転売</h2>


             <form action="{{ route('products.store') }}" method="POST" class="space-y-4" >
                 @csrf







                   <div class="flex items-center">
                     <label for="employer_id" class="w-1/3 text-right pr-4 font-medium">営業所</label>
                     <div class="w-2/3">
                         <input type="text" id="office_name" name="office_name" required value="" placeholder="営業所を入力" class="w-full px-3 py-2 border rounded-md">

                     </div>
                 </div>
                 <div class="flex items-center">
                     <label for="maker_name"  class="w-1/3 text-right pr-4 font-medium">メーカー名</label>
                     <div class="w-2/3">
                         <input type="text" id="maker_name" name="maker_name" placeholder="メーカー名" required class="w-full px-3 py-2 border rounded-md">
                     </div>
                 </div>



                 <div class="flex items-center">
                     <label for="product_number" class="w-1/3 text-right pr-4 font-medium">商品番号</label>
                     <div class="w-2/3">
                         <input type="text" id="product_number" name="product_number" placeholder="商品番号入力" required class="w-full px-3 py-2 border rounded-md">
                     </div>
                 </div>

                 <div class="flex items-center">
                     <label for="product_name" class="w-1/3 text-right pr-4 font-medium">商品名</label>
                     <div class="w-2/3">
                         <input type="text" id="product_name" name="product_name" placeholder="商品名" required class="w-full px-3 py-2 border rounded-md">
                     </div>
                 </div>

                 <div class="flex items-center">
                     <label for="pieces" class="w-1/3 text-right pr-4 font-medium">数量</label>
                     <div class="w-2/3">
                         <input type="number" id="pieces" name="pieces" placeholder="数、数字を入力してください。" required class="w-full px-3 py-2 border rounded-md">
                     </div>
                 </div>

                 <div class="flex items-center">
                     <label for="icm_net" class="w-1/3 text-right pr-4 font-medium">ICM NET</label>
                     <div class="w-2/3">
                         <input type="number" id="icm_net" name="icm_net" placeholder="数、数字を入力してください。" class="w-full px-3 py-2 border rounded-md">
                     </div>
                 </div>

                 <div class="flex items-center">
                     <label for="purchase_date" class="w-1/3 text-right pr-4 font-medium">購入日</label>
                     <div class="w-2/3">
                         <input type="date" id="purchase_date" name="purchase_date" class="w-full px-3 py-2 border rounded-md">
                     </div>
                 </div>

                 <div class="flex items-center">
                     <label for="purchased_from" class="w-1/3 text-right pr-4 font-medium">購入先</label>
                     <div class="w-2/3">
                         <input type="text" id="purchased_from" name="purchased_from" class="w-full px-3 py-2 border rounded-md" placeholder="購入先入力">
                     </div>
                 </div>

                 <div class="flex items-center">
                     <label for="list_price" class="w-1/3 text-right pr-4 font-medium">定価</label>
                     <div class="w-2/3">
                         <input type="number" id="list_price" name="list_price" class="w-full px-3 py-2 border rounded-md" placeholder="定価、数字でで入力してください。">
                     </div>
                 </div>
                 <div class="flex items-center">
                     <label for="remarks" class="w-1/3 text-right pr-4 font-medium">備考</label>
                     <div class="w-2/3">
                         <input type="text" id="remarks" name="remarks" class="w-full px-3 py-2 border rounded-md" placeholder="もしあれば入力">
                     </div>
                 </div>






                 {{-- <button type="submit" class="submit-button">追加</button> --}}
                 <div class="flex justify-between mt-3">
                     <x-button purpose="default" type="" href="{{ route('products.index') }}">
                         戻る
                     </x-button>
                     <x-button purpose="search" type="submit">
                         追加
                     </x-button>

                 </div>


             </form>

        </div>


    </div>

</div>




</x-app-layout>





