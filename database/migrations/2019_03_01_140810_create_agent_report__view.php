<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
USE Illuminate\Support\Facades\DB;

class CreateAgentReportView extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        DB::statement("
                        CREATE VIEW view_agent_info AS
                        SELECT
                            agent.email,
                            agent.password,
                            agent.first_name,
                            agent.last_name,
                            agent.middle_initial,
                            agent.contact_number,
                            agent.branch_uuid,

                            branch.name as branch_name,
                            branch.address,
                            branch.brand_uuid,

                            brand.name as brand_name,
                            brand.category_uuid,

                            category.name

                        FROM
                            agents agent
                        LEFT JOIN
                            branches branch
                        ON
                            agent.branch_uuid = branch.uuid
                        LEFT JOIN
                            brands brand
                        ON
                            branch.brand_uuid = brand.uuid
                        LEFT JOIN
                            categories category
                        ON
                            brand.category_uuid = category.uuid"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        DB::statement("DROP VIEW agent_info_report");
    }

}
