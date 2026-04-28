const API_BASE = 'http://localhost:8080/api';
document.getElementById('apiLabel').textContent = API_BASE;

const entities = {
  categorias: { label: 'Categorías', fields: ['nombre','descripcion','activo'] },
  productos: { label: 'Productos', fields: ['categoria_id','nombre','descripcion','precio','stock','activo'] },
  clientes: { label: 'Clientes', fields: ['nombre','email','telefono'] },
  pedidos: { label: 'Pedidos', fields: ['cliente_id','fecha','estado','total'] },
  pedido_items: { label: 'Items de pedido', fields: ['pedido_id','producto_id','cantidad','precio_unitario'] }
};
let current = 'categorias';
let editingId = null;

const tabs = document.getElementById('tabs');
const form = document.getElementById('entityForm');
const thead = document.getElementById('thead');
const tbody = document.getElementById('tbody');
const message = document.getElementById('message');
const search = document.getElementById('search');
const tableTitle = document.getElementById('tableTitle');

function showMessage(text){ message.textContent = text; setTimeout(()=> message.textContent='', 4500); }
function inputType(field){
  if(['precio','total','precio_unitario'].includes(field)) return 'number';
  if(['stock','cantidad','categoria_id','cliente_id','pedido_id','producto_id'].includes(field)) return 'number';
  if(field === 'fecha') return 'datetime-local';
  return 'text';
}
function renderTabs(){
  tabs.innerHTML = Object.entries(entities).map(([key,e]) => `<button class="tab ${key===current?'active':''}" onclick="selectEntity('${key}')">${e.label}</button>`).join('');
}
function renderForm(data={}){
  const fields = entities[current].fields;
  form.innerHTML = `<h2>${editingId ? 'Editar' : 'Crear'} ${entities[current].label}</h2>` + fields.map(f => {
    if(f === 'activo') return `<label>${f}<select name="${f}"><option value="true" ${data[f]===true?'selected':''}>true</option><option value="false" ${data[f]===false?'selected':''}>false</option></select></label>`;
    if(f === 'estado') return `<label>${f}<select name="${f}">${['PENDIENTE','PAGADO','PREPARANDO','ENTREGADO','CANCELADO'].map(s=>`<option ${data[f]===s?'selected':''}>${s}</option>`).join('')}</select></label>`;
    return `<label>${f}<input name="${f}" type="${inputType(f)}" value="${data[f] ?? ''}" /></label>`;
  }).join('') + `<div class="actions"><button class="primary" type="submit">${editingId?'Actualizar':'Crear'}</button><button class="secondary" type="button" onclick="resetForm()">Limpiar</button></div>`;
}
async function loadData(){
  try{
    const term = search.value.trim();
    const url = term ? `${API_BASE}/${current}/filter?search=${encodeURIComponent(term)}` : `${API_BASE}/${current}`;
    const {data} = await axios.get(url);
    renderTable(Array.isArray(data) ? data : []);
  }catch(err){ showMessage('Error cargando datos: ' + (err.response?.data?.error || err.message)); }
}
function renderTable(rows){
  tableTitle.textContent = entities[current].label;
  const cols = rows[0] ? Object.keys(rows[0]) : ['id', ...entities[current].fields];
  thead.innerHTML = `<tr>${cols.map(c=>`<th>${c}</th>`).join('')}<th>Acciones</th></tr>`;
  tbody.innerHTML = rows.map(row => `<tr>${cols.map(c=>`<td>${row[c] ?? ''}</td>`).join('')}<td class="actions"><button class="secondary" onclick='editRow(${JSON.stringify(row)})'>Editar</button><button class="danger" onclick="deleteRow(${row.id})">Eliminar</button></td></tr>`).join('');
}
function selectEntity(key){ current = key; editingId = null; search.value=''; renderTabs(); renderForm(); loadData(); }
function resetForm(){ editingId = null; renderForm(); }
function editRow(row){ editingId = row.id; renderForm(row); window.scrollTo({top:0, behavior:'smooth'}); }
async function deleteRow(id){
  if(!confirm('¿Eliminar registro?')) return;
  try{ await axios.delete(`${API_BASE}/${current}/${id}`); showMessage('Registro eliminado'); loadData(); }
  catch(err){ showMessage('No se pudo eliminar: ' + (err.response?.data?.detail || err.response?.data?.error || err.message)); }
}
form.addEventListener('submit', async (e)=>{
  e.preventDefault();
  const payload = {};
  new FormData(form).forEach((value,key)=>{
    if(value === '') return;
    if(value === 'true' || value === 'false') payload[key] = value === 'true';
    else if(['precio','total','precio_unitario'].includes(key)) payload[key] = Number(value);
    else if(['stock','cantidad','categoria_id','cliente_id','pedido_id','producto_id'].includes(key)) payload[key] = Number(value);
    else payload[key] = value;
  });
  try{
    if(editingId) await axios.put(`${API_BASE}/${current}/${editingId}`, payload);
    else await axios.post(`${API_BASE}/${current}`, payload);
    showMessage(editingId ? 'Registro actualizado' : 'Registro creado');
    resetForm(); loadData();
  }catch(err){ showMessage('Error guardando: ' + (err.response?.data?.detail || err.response?.data?.error || err.message)); }
});
search.addEventListener('input', () => loadData());
renderTabs(); renderForm(); loadData();
