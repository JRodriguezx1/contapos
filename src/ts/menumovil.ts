

const mobilemenu1 = document.querySelector('#mobile-menu1')as HTMLButtonElement;
const miDialogomenumovil = document.querySelector('#miDialogomenumovil') as any;

mobilemenu1.addEventListener('click', ()=>{
    miDialogomenumovil.showModal();
    document.addEventListener('click', cerrarDialogoExterno);
});


function cerrarDialogoExterno(event:Event){
 const f = event.target;
 if(f === miDialogomenumovil){
    miDialogomenumovil.close();
 }
}
