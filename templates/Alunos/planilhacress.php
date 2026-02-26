<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno $aluno
 */
?>

<?= $this->element('menu_mural') ?>

<?php
$user = $this->request->getAttribute('identity');
if ($user && $user->categoria == 1): ?>
    <div class="container mt-2">
        <button id="btn-report-md" class="btn btn-info btn-sm">
            <i class="fas fa-download"></i>Baixar Relatório (Markdown)
        </button>
    </div>
<?php endif; ?>

<script>
    var base_url = "<?= $this->Html->Url->build(['controller' => 'alunos', 'action' => 'planilhacress']); ?>";

    $(document).ready(function () {
        $("#EstudantesPeriodo").change(function () {
            var periodo = $(this).val();
            window.location = base_url + "?periodo=" + periodo;
        });
    });
</script>

<style>
    th { cursor: pointer; }
    th:hover { background-color: #e9ecef; }
    .sort-icon { color: #0d6efd; }
</style>

<?= $this->element('templates') ?>

<div class='container'>
        <?= $this->Form->create(null, ['class' => 'form-inline']); ?>
        <div class="form-group row">
            <label class='col-sm-1 col-form-label'>Período</label>
            <div class='col-sm-2'>
                <?= $this->Form->input('periodo', ['type' => 'select', 'id' => 'EstudantesPeriodo', 'label' => ['text' => 'Período'], 'options' => $periodos, 'empty' => [$periodoselecionado => $periodoselecionado]], ['class' => 'form-control']); ?>
            </div>
        </div>
        <?= $this->Form->end(); ?>

    <table class='table table-hover table-striped table-responsive' id='sortableTable'>
        <caption style='caption-side: top;'>Escola de Serviço Social da UFRJ. Planilha de estagiários para o CRESS 7ª
            Região</caption>
        <thead class='thead-light'>
            <tr>
                <th onclick="sortTable(0, 'text')">Aluno(a) <span class="sort-icon"></span></th>
                <th onclick="sortTable(1, 'text')">Instituição <span class="sort-icon"></span></th>
                <th onclick="sortTable(2, 'text')">Endereço <span class="sort-icon"></span></th>
                <th onclick="sortTable(3, 'text')">CEP <span class="sort-icon"></span></th>
                <th onclick="sortTable(4, 'text')">Bairro <span class="sort-icon"></span></th>
                <th onclick="sortTable(5, 'text')">Supervisor(a) <span class="sort-icon"></span></th>
                <th onclick="sortTable(6, 'text')">CRESS <span class="sort-icon"></span></th>
                <th onclick="sortTable(7, 'text')">Professor(a) <span class="sort-icon"></span></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($cress as $c_cress): ?>
            <?php // pr($c_cress); ?>
            <tr>
                <td><?php echo isset($c_cress->aluno->nome) ? $this->Html->link($c_cress->aluno->nome, '/alunos/view/' . $c_cress->aluno->id) : 'Sem informação'; ?>
                </td>
                <td><?php echo isset($c_cress->instituicao->instituicao) ? $this->Html->link($c_cress->instituicao->instituicao, '/instituicoes/view/' . $c_cress->instituicao->id) : 'Sem informação'; ?>
                </td>
                <td><?php echo isset($c_cress->instituicao->endereco) ? $c_cress->instituicao->endereco : ''; ?></td>
                <td><?php echo isset($c_cress->instituicao->cep) ? $c_cress->instituicao->cep : ''; ?></td>
                <td><?php echo isset($c_cress->instituicao->bairro) ? $c_cress->instituicao->bairro : ''; ?></td>
                <td><?php echo isset($c_cress->supervisor->nome) ? $c_cress->supervisor->nome : ''; ?></td>
                <td><?php echo isset($c_cress->supervisor->cress) ? $c_cress->supervisor->cress : ''; ?></td>
                <td><?php echo isset($c_cress->professor->nome) ? $c_cress->professor->nome : ''; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script type="text/javascript">

let sortDirection = {}; 

function sortTable(columnIndex, type) {
  const table = document.getElementById("sortableTable");
  if (!table) return;
  const tbody = table.tBodies[0];
  if (!tbody) return;
  
  let rows = Array.from(tbody.rows);
  
  // Toggle direction for this column, defaulting to 'asc'
  const currentDirection = sortDirection[columnIndex] === 'asc' ? 'desc' : 'asc';
  sortDirection[columnIndex] = currentDirection;

  // Update icons for all headers
  const headers = table.querySelectorAll('th');
  headers.forEach((th, index) => {
    const icon = th.querySelector('.sort-icon');
    if (icon) {
      if (index === columnIndex) {
        icon.textContent = currentDirection === 'asc' ? ' ▲' : ' ▼';
      } else {
        icon.textContent = '';
      }
    }
  });

  const parseDate = (str) => {
    if (!str || str.toLowerCase() === 's/d') return new Date(0);
    
    // Clean string and handle both / and -
    const cleanStr = str.trim().replace(/\//g, '-');
    const parts = cleanStr.split('-');
    
    if (parts.length === 3) {
      // Check if it's YYYY-MM-DD or DD-MM-YYYY
      if (parts[0].length === 4) {
        // YYYY-MM-DD
        return new Date(parts[0], parts[1] - 1, parts[2]);
      } else if (parts[2].length === 4) {
        // DD-MM-YYYY
        return new Date(parts[2], parts[1] - 1, parts[0]);
      }
    }
    
    const d = new Date(cleanStr);
    return isNaN(d.getTime()) ? new Date(0) : d;
  };

  rows.sort((rowA, rowB) => {
    let cellA = rowA.cells[columnIndex].textContent.trim();
    let cellB = rowB.cells[columnIndex].textContent.trim();

    if (type === 'numeric') {
      // Handle Brazilian format (commas for decimals) and non-numeric characters
      const extractNum = (s) => parseFloat(s.replace(/[^\d,-]/g, '').replace(',', '.')) || 0;
      const valA = extractNum(cellA);
      const valB = extractNum(cellB);
      return currentDirection === 'asc' ? valA - valB : valB - valA;
    } else if (type === 'date') {
      const valA = parseDate(cellA).getTime();
      const valB = parseDate(cellB).getTime();
      return currentDirection === 'asc' ? valA - valB : valB - valA;
    } else {
      // Case-insensitive locale comparison
      return currentDirection === 'asc' 
        ? cellA.localeCompare(cellB, undefined, {sensitivity: 'base'}) 
        : cellB.localeCompare(cellA, undefined, {sensitivity: 'base'});
    }
  });

  // Efficiently re-append rows
  const fragment = document.createDocumentFragment();
  rows.forEach(row => fragment.appendChild(row));
  tbody.appendChild(fragment);
}

// Generate and download Markdown report
$(document).ready(function() {
  $("#btn-report-md").on("click", function () {
    const table = document.getElementById("sortableTable");
    if (!table) return;
    
    const tbody = table.tBodies[0];
    if (!tbody || tbody.rows.length === 0) {
      alert("Não há dados para exportar.");
      return;
    }
    
    const periodo = $("#EstudantesPeriodo").val() || '<?= $periodoselecionado ?>';

    let markdown = `# Relatório de Estagiários - Período: ${periodo}\n\n`;
    markdown += `| Aluno | Instituição | Endereço | CEP | Bairro | Supervisor | CRESS | Professor |\n`;
    markdown += `| :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- |\n`;

    Array.from(tbody.rows).forEach(row => {
      const cells = row.cells;
      const aluno = cells[0]?.textContent.trim() || "-";
      const instituicao = cells[1]?.textContent.trim() || "-";
      const endereco = cells[2]?.textContent.trim() || "-";
      const cep = cells[3]?.textContent.trim() || "-";
      const bairro = cells[4]?.textContent.trim() || "-";
      const supervisor = cells[5]?.textContent.trim() || "-";
      const cress = cells[6]?.textContent.trim() || "-";
      const professor = cells[7]?.textContent.trim() || "-";

      markdown += `| ${aluno} | ${instituicao} | ${endereco} | ${cep} | ${bairro} | ${supervisor} | ${cress} | ${professor} |\n`;
    });

    const blob = new Blob([markdown], { type: 'text/markdown' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `relatorio_estagiarios_${periodo.replace(/\//g, '-')}.md`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
  });
});
</script>