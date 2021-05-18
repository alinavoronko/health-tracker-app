
namespace MarathonService.Models
{
  public class MarathonParticipant
  {
    public long MarathonId;
    public long ParticipantId;

    public virtual Marathon Marathon { get; set; }
  }
}
