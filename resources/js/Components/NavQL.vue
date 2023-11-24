<template lang="">
    <div class="flex justify-center items-center h-full">
        <nav class="bg-gray w-max flex justify-center items-center mt-12">
          <div class="px-4 py-3 mx-auto">
            <div class="flex items-center">
              <ul class="flex flex-row font-medium mt-0 space-x-8 text-sm">
                <li>
                  <div class="text-gray-900 hover:underline {{ $isActive === 'currentAwareness' ? 'border-b-2 border-green' : '' }}">
                    <a href="#">Current Awareness</a>
                  </div>
                </li>
                <li>
                  <div class="text-gray-900 hover:underline {{ $isActive === 'ulsForms' ? 'border-b-2 border-green' : '' }}">
                    <a href="#">ULS Forms</a>
                  </div>
                </li>
                <li>
                  <div class="text-gray-900 hover:underline {{ $isActive === 'virtualLibraries' ? 'border-b-2 border-green' : '' }}">
                    <a href="#">Virtual Libraries</a>
                  </div>
                </li>
                <li>
                  <div class="text-gray-900 hover:underline {{ $isActive === 'librarySearchTools' ? 'border-b-2 border-green' : '' }}">
                    <a href="#">Library Search Tools</a>
                  </div>
                </li>
                <li>
                  <div class="text-gray-900 hover:underline {{ $isActive === 'featuredLinks' ? 'border-b-2 border-green' : '' }}">
                    <a href="#">Featured Links</a>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </nav>
      </div>
      
      
</template>
<script>
export default {
    
}
</script>
<style lang="">
    
</style>