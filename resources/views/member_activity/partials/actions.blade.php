<div class="btn-group" role="group">
    {{-- Ver --}}
    <a href="{{ route('member_activity.show', $r->id) }}" 
       class="btn btn-sm btn-outline-info" 
       title="Ver detalle">
        <i class="fas fa-eye"></i>
    </a>

    {{-- Editar --}}
    <a href="{{ route('member_activity.edit', $r->id) }}" 
       class="btn btn-sm btn-outline-primary" 
       title="Editar inscripción">
        <i class="fas fa-edit"></i>
    </a>

    {{-- Eliminar --}}
    <form action="{{ route('member_activity.destroy', $r->id) }}" 
          method="POST" 
          class="d-inline" 
          onsubmit="return confirm('¿Estás seguro de eliminar esta inscripción?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
            <i class="fas fa-trash"></i>
        </button>
    </form>
</div>
