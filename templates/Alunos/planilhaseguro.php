<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno[]|\Cake\Collection\CollectionInterface $t_seguro
 * @var \App\Model\Entity\Aluno[]|\Cake\Collection\CollectionInterface $periodos
 * @var string $periodoselecionado
 */
?>

<?= $this->element('menu_mural') ?>

<script>
    var base_url = "<?= $this->Html->Url->build(['controller' => 'Alunos', 'action' => 'planilhaseguro']); ?>";

    $(document).ready(function () {
        $("#periodo").change(function () {
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

<div class="container">

    <?= $this->Form->create(null, ['url' => 'index', 'class' => 'form-inline']); ?>
    <div class="form-group row">
        <label class='col-sm-1 col-form-label'>Período</label>
        <div class='col-sm-2'>
            <?= $this->Form->input('periodo', ['id' => 'periodo', 'type' => 'select', 'label' => false, 'options' => $periodos, 'empty' => [$periodoselecionado => $periodoselecionado]], ['class' => 'form-control']); ?>
        </div>
    </div>
    <?= $this->Form->end(); ?>

    <table class='table table-striped table-hover table-responsive' id="sortableTable">
    <caption style='caption-side: top'>Planilha para seguro de vida dos alunos estagiários</caption>
    <thead class='thead-light'>
            <tr>
                <th onclick="sortTable(0, 'text')">Nome <span class="sort-icon"></span></th>
                <th onclick="sortTable(1, 'text')">CPF <span class="sort-icon"></span></th>
                <th onclick="sortTable(2, 'date')">Nascimento <span class="sort-icon"></span></th>
                <th onclick="sortTable(3, 'text')">DRE <span class="sort-icon"></span></th>
                <th onclick="sortTable(4, 'text')">Curso <span class="sort-icon"></span></th>
                <th onclick="sortTable(5, 'text')">Nível <span class="sort-icon"></span></th>
                <th onclick="sortTable(6, 'text')">Ajuste 2020 <span class="sort-icon"></span></th>
                <th onclick="sortTable(7, 'text')">Período <span class="sort-icon"></span></th>
                <th onclick="sortTable(8, 'date')">Início <span class="sort-icon"></span></th>
                <th onclick="sortTable(9, 'date')">Final <span class="sort-icon"></span></th>
                <th onclick="sortTable(10, 'text')">Instituição <span class="sort-icon"></span></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($t_seguro as $cada_aluno): ?>
            <tr>
                <td>
                    <?php echo $this->Html->link($cada_aluno['nome'], ['controller' => 'Alunos', 'action' => 'view', $cada_aluno['id']]); ?>
                </td>
                <td>
                    <?php echo $cada_aluno['cpf']; ?>
                </td>
                <td>
                    <?php echo $cada_aluno['nascimento']; ?>
                </td>
                <td>
                    <?php echo $cada_aluno['registro']; ?>
                </td>
                <td>
                    <?php echo $cada_aluno['curso']; ?>
                </td>
                <td>
                    <?php echo $cada_aluno['nivel']; ?>
                </td>
                <td>
                    <?php if ($cada_aluno['ajuste2020'] == 0): ?>
                        <?php echo "4 períodos"; ?>
                    <?php elseif ($cada_aluno['ajuste2020'] == 1): ?>
                        <?php echo "3 períodos"; ?>
                    <?php else: ?>
                        <?php echo "s/d"; ?>
                    <?php endif; ?>
                </td>
                <td>
                    <?php echo $cada_aluno['periodo']; ?>
                </td>
                <td>
                    <?php echo $cada_aluno['inicio']; ?>
                </td>
                <td>
                    <?php echo $cada_aluno['final']; ?>
                </td>
                <td>
                    <?php echo $cada_aluno['instituicao']; ?>
                </td>
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
</script>