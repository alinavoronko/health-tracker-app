using System;
using Microsoft.EntityFrameworkCore.Metadata;
using Microsoft.EntityFrameworkCore.Migrations;

namespace marathon.Migrations
{
    public partial class InitialCreate : Migration
    {
        protected override void Up(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.CreateTable(
                name: "Marathons",
                columns: table => new
                {
                    Id = table.Column<long>(type: "bigint", nullable: false)
                        .Annotation("MySql:ValueGenerationStrategy", MySqlValueGenerationStrategy.IdentityColumn),
                    StartDate = table.Column<DateTime>(type: "datetime(6)", nullable: false),
                    Goal = table.Column<float>(type: "float", nullable: false),
                    CreatorId = table.Column<long>(type: "bigint", nullable: false),
                    CreatedAt = table.Column<DateTime>(type: "datetime(6)", nullable: false),
                    UpdatedAt = table.Column<DateTime>(type: "datetime(6)", nullable: false)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_Marathons", x => x.Id);
                });

            migrationBuilder.CreateTable(
                name: "MarathonParticipants",
                columns: table => new
                {
                    MarathonId = table.Column<long>(type: "bigint", nullable: false),
                    ParticipantId = table.Column<long>(type: "bigint", nullable: false)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_MarathonParticipants", x => new { x.MarathonId, x.ParticipantId });
                    table.ForeignKey(
                        name: "MARATHON_PARTICIPANT_MARATHON_ID",
                        column: x => x.MarathonId,
                        principalTable: "Marathons",
                        principalColumn: "Id",
                        onDelete: ReferentialAction.Cascade);
                });
        }

        protected override void Down(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.DropTable(
                name: "MarathonParticipants");

            migrationBuilder.DropTable(
                name: "Marathons");
        }
    }
}
