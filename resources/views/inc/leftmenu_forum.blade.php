
<div id="cat_container" class="flex flex-col w-[20%] mt-5">

  <div id="cc_header" class="h-14 w-full border-b-[1px] border-red-900 bg-neutral-900/90 text-center text-white font-bold text-2xl pt-1 tracking-wider pt-3">
    <span class="mt-5">Катеогрии</span>
  </div>

  <div id="cc_list" class="text-white overflow-y-auto h-screen">
    @include('categories.other')
    @include('categories.tech')
    @include('categories.games')
    @include('categories.creativity')
    @include('categories.subject')
  </div>
  <div class="list_footer bg-neutral-900/90 h-8 w-full border-t-[1px] border-red-900">

  </div>
</div>
