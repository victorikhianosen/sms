 <div>

     <div class="flex flex-col bg-white rounded-lg py-6 p-6 md:px-8">

         <div class="pt-4 pb-10 ">
             <h3 class="font-bold text-2xl ">Send Bulk</h3>

         </div>
         <div class="-m-1.5 overflow-x-auto">
             <div class="p-1.5 min-w-full inline-block align-middle">

                 <div class="overflow-x-auto">

                     <form class="space-y-4">
                         <div class="">
                             <label class="block text-start text-base font-medium text-gray">Sender</label>
                             <select autocomplete="off"
                                 class="w-full lg:w-2/5 px-3 py-4 border-2 text-sm border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue">
                                 <option disabled selected>Select a sender</option>
                                 <option value="victor">Victor</option>
                                 <option value="john">John</option>
                                 <option value="jane">Jane</option>
                             </select>
                         </div>

                         <div class="">
                             <label class="block text-start text-base font-medium text-gray">Message</label>
                             <textarea
                                 class="w-full lg:w-2/5 px-3 py-2 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue placeholder:text-sm"
                                 placeholder="Enter your message" cols="20" rows="3"></textarea>
                         </div>


                         <div class="">
                             <label class="block text-start text-base font-medium text-gray">Phone Numbers</label>
                             <input type="file" autocomplete="off"
                                 class="w-full lg:w-2/5 px-3 py-4 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue placeholder:text-sm"
                                 placeholder="Receiver's phone number">
                         </div>

                         <div class="pt-4">
                            <button class="bg-blue ms:w-full py-3 px-12 rounded-lg text-white text-base">
                                Send
                            </button>
                         </div>
                     </form>
                 </div>

             </div>
         </div>
     </div>





 </div>
