using System.Text.Json.Serialization;

namespace MarathonService.Models
{
  public class MarathonParticipant
  {
    public long MarathonId { get; set; }
    public long ParticipantId { get; set; }

    [JsonIgnore]
    public virtual Marathon Marathon { get; set; }
  }
}
