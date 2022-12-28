<div class="">

    
    <div class="w-1/2 mx-auto mt-10 sm:px-6 lg:px-8">
        <div class="bg-white w-full h-full overflow-hidden p-5 rounded-xl">
            <div class="flex mb-4">
                <img src="https://ui-avatars.com/api/?name=H+W&color=7F9CF5&background=EBF4FF" class="w-8 h-8 rounded-full" alt="">
                <p class="ml-2 text-gray-700 self-center text-sm">
                    {{ Auth()->user()->name  }}
                </p>
            </div>
            <textarea name="" wire:model="new_post.description" id="" cols="30" rows="3" class="w-full mb-0 h-full  border border-gray-300 active:border-gray-900"></textarea>
            @error('new_post.description') <span class="error text-red-500 text-xs">{{ $message }}</span> @enderror
            
            <input type="file" wire:model="new_post.image" class="border border-gray-300 w-full mt-4" accept="image/*">
            @error('new_post.image') <span class="error text-red-500 text-xs">{{ $message }}</span> @enderror

            <div class="w-full text-right mt-3">
                <button class=" bg-white border border-blue-400 hover:bg-blue-400 hover:text-white text-xs py-2 px-5 rounded-full text-blue-400" wire:click="new_post">
                    Send
                </button>
           </div>
        </div>
    </div>
    <div class="pb-10">
        @foreach ($all_post as  $item)
            @php
                $imageFile = $item->image;
            @endphp
            <div class="w-1/2 mx-auto mt-6 sm:px-6 lg:px-8">
                <div class="bg-white w-full h-full  p-5 rounded-xl">
                    <section id="post">
                        <div class="flex justify-between mb-4">
                            <div class="flex">
                                <img src="{{ $item->user->profile_photo_url }}" class="w-8 h-8 rounded-full" alt="">
                                <div class="">
                                    <p class="ml-2 text-gray-800 self-center text-sm">
                                        {{ $item->user->name  }}
                                    </p>
                                    <p class="ml-2 text-gray-700 self-center text-xs">
                                        {{ $item->created_at->diffForHumans()  }}
                                    </p>
                                </div>
                            </div>
                           @if ($item->user_id == Auth()->user()->id)
                            <div class="bg-white" >
                                <div class="">
                                    <div class="relative" x-data="{ open: false }">
                                        <button type="button" @click.away="open = false" @click="open = open ? false : true" class="text-gray-500 group bg-white rounded-md inline-flex items-center text-base font-medium hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-gray-600 mx-2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                                            </svg>   
                                        </button>
                                        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" x-description="Flyout menu, show/hide based on flyout menu state." class="absolute z-10 left-1/2 transform -translate-x-1/2 mt-3 px-2 w-screen max-w-xs sm:px-0" x-ref="panel" >
                                            <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
                                                <div class="relative grid gap-6 bg-white ">
                                                    
                                                    <button wire:click="delete_post({{ $item->id }})" class="-m-3 text-left p-3 block rounded-md hover:bg-gray-50 px-5 py-6 sm:gap-8 sm:p-8 transition ease-in-out duration-150">
                                                        <p class="text-sm font-medium text-gray-900">
                                                            Delete
                                                        </p>
                                                        <p class="mt-1 text-xs text-gray-500">
                                                            Delete this Post
                                                        </p>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div> 
                           @endif
                        </div>
                        @if ($imageFile)
                            <img src="{{ Asset("storage/$imageFile") }}" class="w-full h-full object-contain" alt=""> 
                        @endif
                        <p class="text-sm mt-4">
                            {{ $item->description }}
                        </p>
                    </section>
                    <section id="like">
                        @php
                            $isLike = $item->likes->where('user_id', 1)->first();
                        @endphp
                        <button class="mt-4 flex {{  $isLike ? "bg-blue-400" : "bg-white border border-gray-300" }} p-1.5 w-fit rounded-full px-2" wire:click="like_post({{ $item->id }})">
                            <div>
                                <svg  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 {{  $isLike ? "text-white" : "text-gray-600" }} ">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75A2.25 2.25 0 0116.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23H5.904M14.25 9h2.25M5.904 18.75c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 01-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 10.203 4.167 9.75 5 9.75h1.053c.472 0 .745.556.5.96a8.958 8.958 0 00-1.302 4.665c0 1.194.232 2.333.654 3.375z" />
                                </svg>
                            </div>
                            <p class="{{ $isLike ? "text-white" : "text-gray-600" }} text-xs self-center ml-2">{{ count($item->likes) }} Like</p>
                        </button>
                    </section>
                    <section id="list_comment">
                        @forelse ($item->comments as $key => $comment_id)
                            <div class="my-4 border-b {{ $key == 0 ? "border-t pt-5" : "" }} pb-4  border-gray-300">
                                <div class="flex">
                                    <img src="https://ui-avatars.com/api/?name=H+W&color=7F9CF5&background=EBF4FF" class="w-6 h-6 rounded-full" alt="">
                                    <p class="ml-2 text-gray-700 self-center text-xs">
                                        {{ Auth()->user()->name  }}
                                    </p>
                                </div>
                                <p class="mt-3 text-xs text-gray-700">
                                    {{ $comment_id->comment   }}
                                </p>
                            </div>
                        @empty
                            <div class="h-1 my-4 border-b border-gray-300"></div>
                        @endforelse
                    </section>

                    <section id="new_comment">
                        <input type="text" wire:keydown.enter="new_comment({{ $item->id }})" wire:model="new_comment.{{ $item->id }}" class="h-10 text-xs w-full border border-gray-300" placeholder="Input & Enter To Comment">
                    </section>
                </div>
            </div>
        @endforeach
    </div>
</div>