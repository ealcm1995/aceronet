use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActividadesTable extends Migration
{
    public function up()
    {
        Schema::create('actividades', function (Blueprint $table) {        
            $table->id();
            $table->date('fecha');
            $table->string('estado');
            $table->string('servicio');
            $table->string('sede');
            $table->string('departamento');
            $table->foreignId('responsable_id')->nullable()->constrained('responsable')->nullOnDelete();
            $table->string('diagnostico');
            $table->text('descripcion');
            $table->text('solucion')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('actividades');
    }
} 